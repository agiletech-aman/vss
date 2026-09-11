<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\DashboardService;
use App\Services\NmsService;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    /**
     * GET /api/dashboard/stats
     */
    public function stats(Request $request, DashboardService $service): JsonResponse
    {
        try {
            $data = $service->getStats();
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            Log::error('Dashboard stats error', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * POST /api/dashboard/refresh
     */
    public function refresh(Request $request, DashboardService $service): JsonResponse
    {
        try {
            $data = $service->refreshStats();
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * GET /api/nms/strip-summary
     *
     * Fast single endpoint for the dashboard KPI strip.
     * All NMS calls run in parallel via Http::pool() — same pattern as DashboardService.
     * Gas data reused from DashboardService cache (no duplicate HTTP call).
     * TTL: 120s (longer than NmsService default so repeat page loads hit cache).
     *
     * Route: Route::get('/api/nms/strip-summary', [DashboardController::class, 'nmsStripSummary']);
     */
    public function nmsStripSummary(): JsonResponse
    {
        try {
            $data = Cache::remember('nms_strip_summary', 120, function () {

                $nmsBase = rtrim(
                    config('external-apis.nms_base',
                        config('apis.nms_base', 'https://nms.cwcnewcctv.in/api/nms/v1')
                    ), '/'
                );

                // ── All NMS calls in parallel ──────────────────────────
                $responses = Http::pool(fn ($pool) => [
                    $pool->as('regions')
                        ->timeout(8)->withoutVerifying()
                        ->get($nmsBase . '/regions'),
                    $pool->as('warehouses')
                        ->timeout(8)->withoutVerifying()
                        ->get($nmsBase . '/warehouses'),
                    $pool->as('byType')
                        ->timeout(8)->withoutVerifying()
                        ->get($nmsBase . '/stats/by-type'),
                    $pool->as('map')
                        ->timeout(8)->withoutVerifying()
                        ->get($nmsBase . '/map'),
                ]);

                // ── Regions ────────────────────────────────────────────
                $regionCount = 0;
                try {
                    if ($responses['regions']->successful()) {
                        $reg = $responses['regions']->json();
                        $regionCount = count($reg['data'] ?? (is_array($reg) ? $reg : []));
                    }
                } catch (\Throwable $e) { Log::warning('Strip: regions failed — ' . $e->getMessage()); }

                // ── Warehouses ─────────────────────────────────────────
                $whCount = $whHealthy = $whDown = 0;
                try {
                    if ($responses['warehouses']->successful()) {
                        $raw = $responses['warehouses']->json();
                        $wh  = collect($raw['data'] ?? (is_array($raw) ? $raw : []));
                        $whCount   = $wh->count();
                        $whHealthy = $wh->filter(fn($w) => strtolower($w['status'] ?? '') === 'healthy')->count();
                        $whDown    = $wh->filter(fn($w) => strtolower($w['status'] ?? '') === 'down')->count();
                    }
                } catch (\Throwable $e) { Log::warning('Strip: warehouses failed — ' . $e->getMessage()); }

                // ── Device counts ──────────────────────────────────────
                $camTotal = $camOnline = 0;
                $nvrTotal = $nvrOnline = 0;
                $epcTotal = $epcOnline = 0;
                $wsTotal  = $wsOnline  = 0;
                try {
                    if ($responses['byType']->successful()) {
                        $types   = collect($responses['byType']->json('data') ?? []);
                        $typeMap = $types->keyBy(fn($t) => strtolower($t['type'] ?? ''));

                        $nvr = $typeMap->first(fn($t, $k) => in_array($k, ['nvr', 'dvr'])) ?? [];
                        $cam = $typeMap->first(fn($t, $k) => in_array($k, ['camera', 'ip camera'])) ?? [];
                        $epc = $typeMap->first(fn($t, $k) => in_array($k, ['embedded pc', 'epc'])) ?? [];
                        $ws  = $typeMap->first(fn($t, $k) => $k === 'workstation') ?? [];

                        $nvrTotal  = (int)($nvr['total']  ?? 0);
                        $nvrOnline = (int)($nvr['online'] ?? 0);
                        $camTotal  = (int)($cam['total']  ?? 0);
                        $camOnline = (int)($cam['online'] ?? 0);
                        $epcTotal  = (int)($epc['total']  ?? 0);
                        $epcOnline = (int)($epc['online'] ?? 0);
                        $wsTotal   = (int)($ws['total']   ?? 0);
                        $wsOnline  = (int)($ws['online']  ?? 0);
                    }
                } catch (\Throwable $e) { Log::warning('Strip: byType failed — ' . $e->getMessage()); }

                // ── BTS radios — from byType (already parsed above) ───
                $btsTotal = $btsOnline = $btsClients = 0;
                try {
                    if (isset($typeMap)) {
                        $bts = $typeMap->first(fn($t, $k) => $k === 'bts') ?? [];
                        $btsTotal  = (int)($bts['total']  ?? 0);
                        $btsOnline = (int)($bts['online'] ?? 0);
                    }
                    // CPE/client count from map pins
                    if ($responses['map']->successful()) {
                        $pins       = collect($responses['map']->json('data') ?? []);
                        $btsClients = $pins->sum('bts_clients');
                    }
                } catch (\Throwable $e) { Log::warning('Strip: BTS failed — ' . $e->getMessage()); }

                // ── All device types array (for Devices tile) ─────────
                $allDeviceTypes = [];
                try {
                    if (isset($types)) {
                        $allDeviceTypes = $types->values()->toArray();
                    }
                } catch (\Throwable $e) {}

                // ── Gas IoT — reuse DashboardService cache ─────────────
                // DashboardService already fetches co2_summary in Http::pool()
                // and caches for 300s. This hits that cache — zero new HTTP calls.
                $co2Total = $co2Online = $co2Alerts = 0;
                $ph3Total = $ph3Online = $ph3Alerts = 0;
                try {
                    $stats   = app(\App\Services\DashboardService::class)->getStats(); // resolved via container
                    $overall = $stats['co2ph3Overall'] ?? [];

                    $co2Total  = ($overall['totalOnlineCO2']   ?? 0) + ($overall['totalOfflineCO2']  ?? 0);
                    $co2Online =  $overall['totalOnlineCO2']   ?? 0;
                    $co2Alerts = $overall['totalOfflineCO2']   ?? 0;  // offline devices

                    $ph3Total  = ($overall['totalOnlinePH3']   ?? 0) + ($overall['totalOfflinePH3']  ?? 0);
                    $ph3Online =  $overall['totalOnlinePH3']   ?? 0;
                    $ph3Alerts = $overall['totalOfflinePH3']   ?? 0;  // offline devices

                    // If NMS stats/by-type returned no camera data, fall back to DashboardService
                    if ($camTotal === 0 && ($stats['cameraTotal'] ?? 0) > 0) {
                        $camTotal  = (int)($stats['cameraTotal']  ?? 0);
                        $camOnline = (int)($stats['cameraOnline'] ?? 0);
                    }
                } catch (\Throwable $e) {
                    Log::warning('Strip: gas/camera fallback failed — ' . $e->getMessage());
                }

                return [
                    'regions'     => $regionCount,
                    'warehouses'  => $whCount,
                    'wh_healthy'  => $whHealthy,
                    'wh_down'     => $whDown,

                    'cam_total'   => $camTotal,
                    'cam_online'  => $camOnline,
                    'cam_offline' => $camTotal - $camOnline,

                    'nvr_total'   => $nvrTotal,
                    'nvr_online'  => $nvrOnline,
                    'nvr_offline' => $nvrTotal - $nvrOnline,

                    'epc_total'   => $epcTotal,
                    'epc_online'  => $epcOnline,
                    'epc_offline' => $epcTotal - $epcOnline,

                    'ws_total'    => $wsTotal,
                    'ws_online'   => $wsOnline,
                    'ws_offline'  => $wsTotal - $wsOnline,

                    'co2_total'   => $co2Total,
                    'co2_online'  => $co2Online,
                    'co2_alerts'  => $co2Alerts,

                    'ph3_total'   => $ph3Total,
                    'ph3_online'  => $ph3Online,
                    'ph3_alerts'  => $ph3Alerts,

                    'bts_total'   => $btsTotal,
                    'bts_online'  => $btsOnline,
                    'bts_offline' => $btsTotal - $btsOnline,
                    'bts_clients' => $btsClients,

                    'device_types' => $allDeviceTypes,

                    'cached_at'   => now()->toIso8601String(),
                ];
            });

            return response()->json(['success' => true, 'data' => $data]);

        } catch (\Throwable $e) {
            Log::error('NMS strip summary error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load summary'], 500);
        }
    }
}
