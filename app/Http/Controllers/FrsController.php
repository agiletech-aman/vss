<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FrsService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FrsController extends Controller
{
    public function index(Request $request, FrsService $service)
    {
        $user           = auth()->user();
        $warehouseNames = $user->getAccessibleWarehouseNames();

        $regionId    = $request->region_id;
        $warehouseId = $request->warehouse_id;
        $fromDate    = $request->from_date;
        $toDate      = $request->to_date;

        $filters = array_filter([
            'region_id'    => $regionId,
            'warehouse_id' => $warehouseId,
            'limit'        => 10000,
        ]);

        $response = $service->fetch($filters);

        $logs = collect($response['logs'] ?? $response['data'] ?? []);

        Log::info('FRS Fetch', [
            'filters'   => $filters,
            'api_count' => $logs->count(),
        ]);

        /* ── Warehouse access filter ── */
        if (!$user->hasRole('superadmin') && !$user->hasRole('admin')) {
            $accessibleUpper = array_map(fn($w) => strtoupper(trim($w)), $warehouseNames);

            $logs = $logs->filter(function ($log) use ($accessibleUpper) {
                $warehouse = strtoupper(trim($log['warehouse'] ?? ''));
                return $warehouse && in_array($warehouse, $accessibleUpper);
            });
        }

        /* ── Date filter ── */
        if ($fromDate && $toDate) {
            $from = Carbon::parse($fromDate)->startOfDay();
            $to   = Carbon::parse($toDate)->endOfDay();

            $logs = $logs->filter(function ($log) use ($from, $to) {
                if (empty($log['timestamp'])) return false;
                return Carbon::parse($log['timestamp'])->between($from, $to);
            });
        }

        /* ── Sort ── */
        $logs = $logs->sortByDesc('timestamp')->values();

        /* ── Export data (no godown / compartment) ── */
        $base = 'https://frsbag.cwcnewiot.in/frs/';

        $allLogsForExport = $logs->map(function ($log) use ($base) {
            $cropUrl  = !empty($log['crop_path'])  ? $base . ltrim($log['crop_path'],  '/') : '';
            $frameUrl = !empty($log['frame_path']) ? $base . ltrim($log['frame_path'], '/') : '';

            return [
                'datetime'   => Carbon::parse($log['timestamp'])->format('d-m-Y H:i:s'),
                'name'       => $log['name']         ?? 'Unknown',
                'status'     => ucfirst($log['status']    ?? 'unknown'),
                'confidence' => isset($log['confidence']) ? round($log['confidence'] * 100, 2) . '%' : '0%',
                'region'     => $log['region']       ?? '-',
                'warehouse'  => $log['warehouse']    ?? '-',
                'camera'     => $log['camera_label'] ?? '-',
                'crop_url'   => $cropUrl,
                'frame_url'  => $frameUrl,
            ];
        })->values()->toArray();

        /* ── Paginate ── */
        $perPage = 10;
        $page    = $request->get('page', 1);

        $paginatedLogs = new LengthAwarePaginator(
            $logs->forPage($page, $perPage),
            $logs->count(),
            $perPage,
            $page,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('iot.frs', [
            'paginatedLogs'    => $paginatedLogs,
            'total'            => $logs->count(),
            'allLogsForExport' => $allLogsForExport,
        ]);
    }

    public function regions(FrsService $service)
    {
        return response()->json($service->regions());
    }

    public function warehouses(FrsService $service)
    {
        return response()->json($service->warehouses());
    }
}
