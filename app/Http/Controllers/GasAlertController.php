<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GasAlertService;


class GasAlertController extends Controller
{
    private const DEVICE_CO2 = 30000;
    private const DEVICE_PH3 = 30001;

    /* AJAX — locations by state */
   public function locationsByState(string $state, GasAlertService $alertService)
    {
        $locations = $alertService->locations($state);

        return response()->json($locations);
    }

    /* ============================================
       MAIN INDEX
    ============================================ */
   public function index(
        Request $request,
        GasAlertService $alertService
    ) {
        $deviceTypeId = in_array((int) $request->get('deviceTypeId'), [
            self::DEVICE_CO2,
            self::DEVICE_PH3,
        ])
            ? (int) $request->get('deviceTypeId')
            : self::DEVICE_CO2;

        $page       = max(1, (int) $request->get('page', 1));
        $pageSize   = 20;

        $stateId    = $request->get('state');
        $locationId = $request->get('location');
        $device     = $request->get('device');
        $alertType  = $request->get('alertType');
        $fromDate   = $request->get('fromDate');
        $toDate     = $request->get('toDate');
        $showNormal = $request->boolean('showNormal');
        $selectedLevel     = strtoupper(trim((string) $alertType));

        $states    = $alertService->states();
        $locations = $stateId ? $alertService->locations((string) $stateId) : [];

        $baseFilters = [
            'deviceTypeId' => $deviceTypeId,
            'state'        => $stateId,
            'location'     => $locationId,
            'device'       => $device,
            'fromDate'     => $fromDate,
            'toDate'       => $toDate,
            'showNormal'   => $showNormal ? 1 : null,
        ];

        $response = $alertService->fetchAlerts($baseFilters + [
            'pageNumber' => $page,
            'pageSize'   => $pageSize,
            'alertType'  => $alertType,
        ]);

        // GasAlertService guarantees that every row belongs to this device type.
        $collection = collect($response['data'] ?? [])->values();
        $gasPrefix = $deviceTypeId === self::DEVICE_PH3 ? 'PH₃-' : 'CO₂-';
        $devices   = $collection
            ->map(fn($a) => $gasPrefix . ($a['shadName'] ?? '') . ($a['columnName'] ?? ''))
            ->unique()->values();

        // KPI cards are counted from the SAME upstream source and the SAME
        // state/location/device/date filters as the table below, instead of
        // a separate summary endpoint — so the cards and the rows can never
        // disagree with each other.
        $kpis = $this->kpisFromAlerts($alertService, $baseFilters);

        $totalRecords = ($selectedLevel !== '' && isset($kpis[strtolower($selectedLevel)]))
            ? (int) $kpis[strtolower($selectedLevel)]
            : (int) $kpis['total'];
        $totalPages   = (int) ceil($totalRecords / $pageSize);

        return view('alerts.gas', [
            'alerts'            => $collection,
            'kpis'              => $kpis,
            'states'            => $states,
            'locations'         => $locations,
            'devices'           => $devices,
            'selectedState'     => $stateId,
            'selectedLocation'  => $locationId,
            'selectedDevice'    => $device,
            'selectedAlertType' => $alertType,
            'fromDate'          => $fromDate,
            'toDate'            => $toDate,
            'showNormal'        => $showNormal,
            'page'              => $page,
            'totalPages'        => $totalPages,
            'totalRecords'      => $totalRecords,
            'deviceTypeId'      => $deviceTypeId,
        ]);
    }

    /**
     * Count Normal/Severe/Critical alerts using the exact same upstream
     * endpoint and filters (state/location/device/date range) as the alert
     * table, so the KPI cards always match what the table actually shows.
     *
     * Uses GasAlertService::reliableTotalCount() (direct upstream totalCount,
     * no local scan) — verified live that normal+severe+critical adds up
     * exactly to the unfiltered total for the same filters.
     */
    private function kpisFromAlerts(GasAlertService $alertService, array $baseFilters): array
    {
        $normal   = $alertService->reliableTotalCount($baseFilters, 'normal');
        $severe   = $alertService->reliableTotalCount($baseFilters, 'severe');
        $critical = $alertService->reliableTotalCount($baseFilters, 'critical');

        return [
            'normal'   => $normal,
            'severe'   => $severe,
            'critical' => $critical,
            'total'    => $normal + $severe + $critical,
        ];
    }

    /* ============================================
       EXPORT EXCEL — fetches ALL records
    ============================================ */
    public function exportExcel(Request $request, GasAlertService $alertService)
    {
        // Unlimited exports can legitimately walk hundreds of thousands of
        // rows across many upstream pages — don't let PHP's default
        // execution-time limit cut the stream off partway through.
        set_time_limit(0);
        ignore_user_abort(true);

        $stateId        = $request->get('state');
        $locationId     = $request->get('location');

        $deviceTypeId = in_array((int) $request->get('deviceTypeId'), [
            self::DEVICE_CO2,
            self::DEVICE_PH3,
        ])
            ? (int) $request->get('deviceTypeId')
            : self::DEVICE_CO2;

        $gasLabel = $deviceTypeId === self::DEVICE_PH3 ? 'PH3' : 'CO2';

        $filters = [
            'deviceTypeId' => $deviceTypeId,
            'state'        => $stateId,
            'location'     => $locationId,
            'alertType'    => $request->get('alertType'),
            'device'       => $request->get('device'),
            'fromDate'     => $request->get('fromDate'),
            'toDate'       => $request->get('toDate'),
            'showNormal'   => $request->boolean('showNormal') ? 1 : null,
        ];

        $selectedAlertType = strtolower(trim((string) $request->get('alertType')));
        $totalForMeta = in_array($selectedAlertType, ['normal', 'severe', 'critical'], true)
            ? $alertService->reliableTotalCount($filters, $selectedAlertType)
            : $alertService->reliableTotalCount($filters, 'normal')
                + $alertService->reliableTotalCount($filters, 'severe')
                + $alertService->reliableTotalCount($filters, 'critical');

        // Build CSV
        $filename = $gasLabel . '_Alerts_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'X-Accel-Buffering'   => 'no',
        ];

        $callback = function () use ($alertService, $filters, $gasLabel, $request, $stateId, $locationId, $totalForMeta) {
            $handle = fopen('php://output', 'w');

            // Meta info rows
            fputcsv($handle, [$gasLabel . ' Gas Alerts Export']);
            fputcsv($handle, ['Generated:', now()->format('d M Y h:i A')]);
            fputcsv($handle, ['Alert Type:', $request->get('alertType') ?: 'All']);
            fputcsv($handle, ['State ID:', $stateId ?: 'All']);
            fputcsv($handle, ['Location ID:', $locationId ?: 'All']);
            fputcsv($handle, ['From Date:', $request->get('fromDate') ?: 'All']);
            fputcsv($handle, ['To Date:', $request->get('toDate') ?: 'All']);
            fputcsv($handle, ['Total Records:', $totalForMeta]);
            fputcsv($handle, []); // blank row

            // Header row
            fputcsv($handle, ['Device', 'Location', 'IP Address', 'Value', 'Level', 'Status', 'Timestamp']);

            // Data rows — streamed straight from upstream, page by page, no row cap.
            $count = 0;
            $alertService->eachAlert($filters, function (array $alert) use ($handle, $gasLabel, &$count) {
                $type = strtoupper($alert['alertType'] ?? 'NORMAL');
                fputcsv($handle, [
                    $gasLabel . '-' . ($alert['shadName'] ?? '') . ($alert['columnName'] ?? ''),
                    $alert['locationName'] ?? '-',
                    $alert['deviceIp']     ?? '-',
                    $alert['deviceValue']  ?? '-',
                    ucfirst(strtolower($type)),
                    $alert['deviceStatus'] ?? '-',
                    isset($alert['regDate'])
                        ? \Carbon\Carbon::parse($alert['regDate'])->format('d/m/Y H:i:s')
                        : '-',
                ]);
                $count++;

                if ($count % 2000 === 0) {
                    flush();
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function export(Request $request, GasAlertService $alertService)
    {
        return $this->exportExcel($request, $alertService);
    }

}
