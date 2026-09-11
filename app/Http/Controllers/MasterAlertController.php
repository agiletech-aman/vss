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
        $user      = auth()->user();
        $locations = $alertService->locations($state);

        if ($user->isRegionOfficer() || $user->isWarehouseOfficer()) {
            $warehouseNames = $user->getAccessibleWarehouseNames();
            $locations = array_values(array_intersect($locations, $warehouseNames));
        }

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
        $user           = auth()->user();
        $warehouseNames = $user->getAccessibleWarehouseNames();

        $deviceTypeId = in_array((int) $request->get('deviceTypeId'), [
            self::DEVICE_CO2,
            self::DEVICE_PH3,
        ])
            ? (int) $request->get('deviceTypeId')
            : self::DEVICE_CO2;

        $page       = max(1, (int) $request->get('page', 1));
        $pageSize   = 20;

        $state      = $request->get('state');
        $location   = $request->get('location');
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
        $locations = $state ? $alertService->locations($state) : [];

        if ($user->isRegionOfficer() || $user->isWarehouseOfficer()) {
            $locations = array_values(array_intersect($locations, $warehouseNames));
        }

        $response = $alertService->fetchAlerts([
            'deviceTypeId' => $deviceTypeId,
            'pageNumber'   => $page,
            'pageSize'     => $pageSize,
            'state'        => $state,
            'location'     => $location,
            'alertType'    => $alertType,
            'device'       => $device,
            'fromDate'     => $fromDate,
            'toDate'       => $toDate,
            'showNormal'   => $showNormal ? 1 : null,
        ]);

        $collection = collect($this->filterByAccessibleWarehouses(
            $response['data'] ?? [],
            $warehouseNames
        ))->filter(
            fn($alert) => (int) ($alert['deviceTypeId'] ?? 0) === $deviceTypeId
        )->values();

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
            'selectedState'     => $state,
            'selectedLocation'  => $location,
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
        $user           = auth()->user();
        $warehouseNames = $user->getAccessibleWarehouseNames();

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
            'state'        => $request->get('state'),
            'location'     => $request->get('location'),
            'alertType'    => $request->get('alertType'),
            'device'       => $request->get('device'),
            'fromDate'     => $request->get('fromDate'),
            'toDate'       => $request->get('toDate'),
            'showNormal'   => $request->boolean('showNormal') ? 1 : null,
        ];

        $response = $alertService->fetchAlerts($filters);
        $data     = $this->filterByAccessibleWarehouses(
            $response['data'] ?? [],
            $warehouseNames
        );
        $data = array_values(array_filter(
            $data,
            fn($alert) => (int) ($alert['deviceTypeId'] ?? 0) === $deviceTypeId
        ));

        // Build CSV
        $filename = $gasLabel . '_Alerts_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
        ];

        $callback = function () use ($data, $gasLabel, $request) {
            $handle = fopen('php://output', 'w');

            // Meta info rows
            fputcsv($handle, [$gasLabel . ' Gas Alerts Export']);
            fputcsv($handle, ['Generated:', now()->format('d M Y h:i A')]);
            fputcsv($handle, ['Alert Type:', $request->get('alertType') ?: 'All']);
            fputcsv($handle, ['State:', $request->get('state') ?: 'All']);
            fputcsv($handle, ['Location:', $request->get('location') ?: 'All']);
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

    /* ============================================
       PRIVATE HELPERS
    ============================================ */
    private function filterByAccessibleWarehouses(array $data, array $warehouseNames): array
    {
        $user = auth()->user();

        if ($user->hasRole('superadmin') || $user->hasRole('admin')) {
            return $data;
        }

        return collect($data)
            ->filter(fn($item) => isset($item['location']) && in_array($item['location'], $warehouseNames))
            ->values()
            ->toArray();
    }
}
