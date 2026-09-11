<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MasterAlertService;
use App\Services\MasterAlertSummaryService;

class MasterAlertController extends Controller
{
    private const DEVICE_CO2 = 30000;
    private const DEVICE_PH3 = 30001;

    /* ============================================
       AJAX — LOCATIONS BY STATE
    ============================================ */
    public function locationsByState(string $state, MasterAlertService $alertService)
    {
        $locations = $alertService->locations($state);

        return response()->json($locations);
    }

    /* ============================================
       MAIN INDEX
    ============================================ */
    public function index(
        Request $request,
        MasterAlertService $alertService,
        MasterAlertSummaryService $summaryService
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

        $summary = $summaryService->fetchSummary();
        $overall = $summary['overall'] ?? [];
        $prefix  = $deviceTypeId === self::DEVICE_PH3 ? 'PH3' : 'CO2';

        $kpis = [
            'normal'   => $overall["totalNormal{$prefix}"]   ?? 0,
            'severe'   => $overall["totalSevere{$prefix}"]   ?? 0,
            'critical' => $overall["totalCritical{$prefix}"] ?? 0,
        ];

        $states    = $alertService->states();
        $locations = $stateId ? $alertService->locations((string) $stateId) : [];

        $response = $alertService->fetchAlerts([
            'deviceTypeId' => $deviceTypeId,
            'pageNumber'   => $page,
            'pageSize'     => $pageSize,
            'state'        => $stateId,
            'location'     => $locationId,
            'alertType'    => $alertType,
            'device'       => $device,
            'fromDate'     => $fromDate,
            'toDate'       => $toDate,
            'showNormal'   => $showNormal ? 1 : null,
        ]);

        $collection = collect($response['data'] ?? []);

        $gasPrefix = $deviceTypeId === self::DEVICE_PH3 ? 'PH₃-' : 'CO₂-';
        $devices   = $collection
            ->map(fn($a) => $gasPrefix . ($a['shadName'] ?? '') . ($a['columnName'] ?? ''))
            ->unique()->values();

        $totalRecords = $response['totalCount'] ?? 0;
        $totalPages   = (int) ceil($totalRecords / $pageSize);

        return view('alerts.index', [
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

    /* ============================================
       EXPORT EXCEL — fetches ALL records
    ============================================ */
    public function exportExcel(Request $request, MasterAlertService $alertService)
    {
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
            'pageNumber'   => 1,
            'pageSize'     => 10000, // fetch all
            'state'        => $stateId,
            'location'     => $locationId,
            'alertType'    => $request->get('alertType'),
            'device'       => $request->get('device'),
            'fromDate'     => $request->get('fromDate'),
            'toDate'       => $request->get('toDate'),
            'showNormal'   => $request->boolean('showNormal') ? 1 : null,
        ];

        $response = $alertService->fetchAlerts($filters);
        $data     = $response['data'] ?? [];

        // Build CSV
        $filename = $gasLabel . '_Alerts_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
        ];

        $callback = function () use ($data, $gasLabel, $request, $stateId, $locationId) {
            $handle = fopen('php://output', 'w');

            // Meta info rows
            fputcsv($handle, [$gasLabel . ' Gas Alerts Export']);
            fputcsv($handle, ['Generated:', now()->format('d M Y h:i A')]);
            fputcsv($handle, ['Alert Type:', $request->get('alertType') ?: 'All']);
            fputcsv($handle, ['State ID:', $stateId ?: 'All']);
            fputcsv($handle, ['Location ID:', $locationId ?: 'All']);
            fputcsv($handle, ['From Date:', $request->get('fromDate') ?: 'All']);
            fputcsv($handle, ['To Date:', $request->get('toDate') ?: 'All']);
            fputcsv($handle, ['Total Records:', count($data)]);
            fputcsv($handle, []); // blank row

            // Header row
            fputcsv($handle, ['Device', 'Location', 'IP Address', 'Value', 'Status', 'Timestamp']);

            // Data rows
            foreach ($data as $alert) {
                $type = strtoupper($alert['alertType'] ?? 'NORMAL');
                fputcsv($handle, [
                    $gasLabel . '-' . ($alert['shadName'] ?? '') . ($alert['columnName'] ?? ''),
                    $alert['locationName'] ?? '-',
                    $alert['deviceIp']     ?? '-',
                    $alert['deviceValue']  ?? '-',
                    ucfirst(strtolower($type)),
                    isset($alert['regDate'])
                        ? \Carbon\Carbon::parse($alert['regDate'])->format('d/m/Y H:i:s')
                        : '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

}
