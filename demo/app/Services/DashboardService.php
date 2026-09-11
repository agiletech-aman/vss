<?php

// ═══════════════════════════════════════════════════════════════
// FILE: app/Services/DashboardService.php
// ═══════════════════════════════════════════════════════════════

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Client\Response;
use App\Services\FrsService;
use App\Services\MasterAlertSummaryService;
use App\Services\NmsService;

class DashboardService
{
    protected $frsService;
    protected $alertSummaryService;
    protected $nmsService;

    public function __construct(
        FrsService $frsService,
        MasterAlertSummaryService $alertSummaryService,
        NmsService $nmsService
    ) {
        $this->frsService          = $frsService;
        $this->alertSummaryService = $alertSummaryService;
        $this->nmsService          = $nmsService;
    }

    private function isOk($response): bool
    {
        return $response instanceof Response && $response->successful();
    }

    public function getStats(): array
    {
        $ttl = config('external-apis.cache_dashboard', 300);
        return Cache::remember('dashboard_stats', $ttl, fn () => $this->fetchAllStats());
    }

    public function refreshStats(): array
    {
        Cache::forget('dashboard_stats');
        return $this->getStats();
    }

    private function fetchAllStats(): array
    {
        $t     = config('external-apis.timeout_default', 20);
        $tSlow = config('external-apis.timeout_slow', 30);

        // ── Parallel pool — all APIs at once ───────────────────────────
        $responses = Http::pool(fn ($pool) => [

            // Camera totals (online / offline / unknown)
            $pool->as('cameraSummary')
                ->timeout($t)
                ->withoutVerifying()
                ->get(config('external-apis.camera_summary')),

            // Fire / Smoke / Rodent detection counts + locationWise breakdown
            $pool->as('alertDashboard')
                ->timeout($tSlow)
                ->withoutVerifying()
                ->get(config('external-apis.alert_dashboard')),

            // Sack counting — overall totals
            $pool->as('sack')
                ->timeout($t)
                ->withoutVerifying()
                ->get(config('external-apis.sack_count')),

            // FRS unknown person count
            $pool->as('frs')
                ->timeout($t)
                ->withoutVerifying()
                ->get(config('external-apis.frs_unknown')),

            // Camera stats grouped by region (for table + bar chart)
            $pool->as('byRegion')
                ->timeout($t)
                ->withoutVerifying()
                ->get(config('external-apis.camera_by_region')),

            // CO2 / PH3 alert severity counts + locationWise breakdown
            $pool->as('co2ph3')
                ->timeout($t)
                ->withoutVerifying()
                ->get(config('external-apis.co2_summary')),
        ]);

        // ── Defaults ───────────────────────────────────────────────────
        $cameraTotal      = 0;
        $cameraOnline     = 0;
        $cameraOffline    = 0;

        $fireDetected     = 0;
        $smokeDetected    = 0;
        $rodentDetected   = 0;
        $fireWarehouses   = 0;
        $smokeWarehouses  = 0;
        $rodentWarehouses = 0;
        $fireLastSeen     = null;
        $smokeLastSeen    = null;
        $rodentLastSeen   = null;

        $co2Severe        = 0;
        $co2Critical      = 0;
        $ph3Severe        = 0;
        $ph3Critical      = 0;
        $co2SensorTotal   = null;
        $ph3SensorTotal   = null;

        // NEW: full CO2/PH3 payload for the widget
        $co2ph3Overall    = [];
        $co2ph3LocationWise = [];

        $sackIn           = 0;
        $sackOut          = 0;
        $sackNet          = 0;

        $frsUnknown       = 0;
        $frsCameraTotal   = null;

        $regionData       = [];
        $mapData          = [];

        $topFireWarehouses   = [];
        $topSmokeWarehouses  = [];
        $topRodentWarehouses = [];
        $locationWise        = [];

        // ── 1. Camera Summary ──────────────────────────────────────────
        try {
            if ($this->isOk($responses['cameraSummary'])) {
                $data = $responses['cameraSummary']->json()['data'] ?? [];

                $cameraTotal   = (int) ($data['total_cameras']   ?? 0);
                $cameraOnline  = (int) ($data['online_cameras']  ?? 0);
                $offline       = (int) ($data['offline_cameras'] ?? 0);
                $unknown       = (int) ($data['unknown_cameras'] ?? 0);
                $cameraOffline = $offline + $unknown;

                Log::info('Camera Summary', compact('cameraTotal', 'cameraOnline', 'cameraOffline'));
            }
        } catch (\Exception $e) {
            Log::error('Camera Summary API error', ['message' => $e->getMessage()]);
        }

        // ── 2. Fire / Smoke / Rodent ───────────────────────────────────
        try {
            if ($this->isOk($responses['alertDashboard'])) {
                $payload   = $responses['alertDashboard']->json();
                $overall   = $payload['overall']      ?? [];
                $locations = $payload['locationWise'] ?? [];

                $fireDetected   = (int) ($overall['totalFire']   ?? 0);
                $smokeDetected  = (int) ($overall['totalSmoke']  ?? 0);
                $rodentDetected = (int) ($overall['totalRodent'] ?? 0);

                $fireWarehouses   = collect($locations)->filter(fn ($l) => ($l['fire']   ?? 0) > 0)->count();
                $smokeWarehouses  = collect($locations)->filter(fn ($l) => ($l['smoke']  ?? 0) > 0)->count();
                $rodentWarehouses = collect($locations)->filter(fn ($l) => ($l['rodent'] ?? 0) > 0)->count();

                $fireLastSeen   = $overall['lastFireDetected']   ?? $overall['lastFire']   ?? null;
                $smokeLastSeen  = $overall['lastSmokeDetected']  ?? $overall['lastSmoke']  ?? null;
                $rodentLastSeen = $overall['lastRodentDetected'] ?? $overall['lastRodent'] ?? null;

                $locationsColl = collect($locations);

                $topFireWarehouses = $locationsColl
                    ->filter(fn ($l) => ($l['fire'] ?? 0) > 0)
                    ->sortByDesc('fire')->take(4)->values()
                    ->map(fn ($l) => [
                        'name'  => $l['locationName'] ?? 'Unknown',
                        'state' => $l['state'] ?? '',
                        'count' => (int) ($l['fire'] ?? 0),
                    ])->all();

                $topSmokeWarehouses = $locationsColl
                    ->filter(fn ($l) => ($l['smoke'] ?? 0) > 0)
                    ->sortByDesc('smoke')->take(4)->values()
                    ->map(fn ($l) => [
                        'name'  => $l['locationName'] ?? 'Unknown',
                        'state' => $l['state'] ?? '',
                        'count' => (int) ($l['smoke'] ?? 0),
                    ])->all();

                $topRodentWarehouses = $locationsColl
                    ->filter(fn ($l) => ($l['rodent'] ?? 0) > 0)
                    ->sortByDesc('rodent')->take(4)->values()
                    ->map(fn ($l) => [
                        'name'  => $l['locationName'] ?? 'Unknown',
                        'state' => $l['state'] ?? '',
                        'count' => (int) ($l['rodent'] ?? 0),
                    ])->all();

                $locationWise = collect($locations)->map(fn ($l) => [
                    'locationName' => $l['locationName'] ?? '',
                    'state'        => $l['state']        ?? '',
                    'fire'         => (int) ($l['fire']   ?? 0),
                    'smoke'        => (int) ($l['smoke']  ?? 0),
                    'rodent'       => (int) ($l['rodent'] ?? 0),
                ])->values()->all();

                Log::info('Alert Dashboard', [
                    'fire'   => $fireDetected,
                    'smoke'  => $smokeDetected,
                    'rodent' => $rodentDetected,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Alert Dashboard API error', ['message' => $e->getMessage()]);
        }

        // ── 3. CO2 / PH3 ──────────────────────────────────────────────
        try {
            if ($this->isOk($responses['co2ph3'])) {
                $payload = $responses['co2ph3']->json();
                $overall = $payload['overall'] ?? [];

                // Scalar stats for KPI cards
                $co2Severe      = (int) ($overall['totalSevereCO2']   ?? 0);
                $co2Critical    = (int) ($overall['totalCriticalCO2'] ?? 0);
                $ph3Severe      = (int) ($overall['totalSeverePH3']   ?? 0);
                $ph3Critical    = (int) ($overall['totalCriticalPH3'] ?? 0);
                $co2SensorTotal = $overall['totalSensorsCO2']         ?? null;
                $ph3SensorTotal = $overall['totalSensorsPH3']         ?? null;

                // Full payload for the CO2/PH3 widget
                // The widget fetches this directly client-side, but we also
                // pass it through the dashboard stats so it's available server-side
                // if needed (e.g. for SSR or caching inspection).
                $co2ph3Overall      = $overall;
                $co2ph3LocationWise = $payload['locationWise'] ?? [];

                Log::info('CO2/PH3 Summary', [
                    'co2Severe'   => $co2Severe,
                    'co2Critical' => $co2Critical,
                    'ph3Severe'   => $ph3Severe,
                    'ph3Critical' => $ph3Critical,
                    'locations'   => count($co2ph3LocationWise),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('CO2/PH3 API error', ['message' => $e->getMessage()]);
        }

        // ── 4. Sack Counting ──────────────────────────────────────────
        try {
            if ($this->isOk($responses['sack'])) {
                $d       = $responses['sack']->json();
                $sackIn  = (int) ($d['total_in_bags']  ?? $d['totalIn']  ?? 0);
                $sackOut = (int) ($d['total_out_bags'] ?? $d['totalOut'] ?? 0);
                $sackNet = (int) ($d['net_bags']       ?? $d['netBags']  ?? ($sackIn - $sackOut));
            }
        } catch (\Exception $e) {
            Log::error('Sack API error', ['message' => $e->getMessage()]);
        }

        // ── 5. FRS Unknown ────────────────────────────────────────────
        try {
            if ($this->isOk($responses['frs'])) {
                $frsData        = $responses['frs']->json();
                $frsUnknown     = (int) ($frsData['unknown_person_count'] ?? $frsData['unknownCount'] ?? 0);
                $frsCameraTotal = $frsData['total_cameras'] ?? $frsData['totalCameras'] ?? null;
            }
        } catch (\Exception $e) {
            Log::error('FRS API error', ['message' => $e->getMessage()]);
        }

        // ── 6. Region Data (camera table + bar chart) ─────────────────
        try {
            if ($this->isOk($responses['byRegion'])) {
                $regionData = $responses['byRegion']->json()['data'] ?? [];

                foreach ($regionData as &$r) {
                    $r['offline_cameras'] = ($r['offline_cameras'] ?? 0) + ($r['unknown_cameras'] ?? 0);
                    $total  = $r['total_cameras'] ?? 0;
                    $online = $r['online_cameras'] ?? 0;
                    $r['online_percent'] = $total > 0 ? round(($online / $total) * 100, 1) : 0;
                    $r['status']         = $r['online_percent'] >= 70 ? 'ok' : 'alert';
                }
                unset($r);

                usort($regionData, fn ($a, $b) => strcasecmp($a['region'] ?? '', $b['region'] ?? ''));
            }
        } catch (\Exception $e) {
            Log::error('Region API error', ['message' => $e->getMessage()]);
        }

        // ── 7. NMS Map Data ───────────────────────────────────────────
        try {
            $mapData = $this->getNMSMapData();
        } catch (\Exception $e) {
            Log::error('NMS Map error', ['message' => $e->getMessage()]);
        }

        // ── Return flat stats array ────────────────────────────────────
        return compact(
            // Camera
            'cameraTotal',
            'cameraOnline',
            'cameraOffline',

            // Fire / Smoke / Rodent
            'fireDetected',
            'smokeDetected',
            'rodentDetected',
            'fireWarehouses',
            'smokeWarehouses',
            'rodentWarehouses',
            'fireLastSeen',
            'smokeLastSeen',
            'rodentLastSeen',
            'topFireWarehouses',
            'topSmokeWarehouses',
            'topRodentWarehouses',
            'locationWise',

            // CO2 / PH3 — scalar KPI values
            'co2Severe',
            'co2Critical',
            'ph3Severe',
            'ph3Critical',
            'co2SensorTotal',
            'ph3SensorTotal',

            // CO2 / PH3 — full payload for widget (optional server-side use)
            'co2ph3Overall',
            'co2ph3LocationWise',

            // Sack overall
            'sackIn',
            'sackOut',
            'sackNet',

            // FRS
            'frsUnknown',
            'frsCameraTotal',

            // Map & table
            'regionData',
            'mapData'
        );
    }

    /**
     * Build NMS map markers from warehouse_locations.json + NMS health data
     */
    private function getNMSMapData(): array
    {
        $mapData = [];

        try {
            $rawAreas = $this->nmsService->fetchCameraHealthMap();

            if (!Storage::exists('geo/warehouse_locations.json')) {
                Log::warning('warehouse_locations.json not found');
                return [];
            }

            $geo = json_decode(Storage::get('geo/warehouse_locations.json'), true);
            if (!$geo) {
                Log::warning('Failed to parse warehouse_locations.json');
                return [];
            }

            $lookup = collect($geo)->mapWithKeys(function ($item) {
                $key = strtolower(preg_replace('/[^a-z0-9]/', '', $item['storeIdentifier']));
                return [$key => $item];
            });

            foreach ($rawAreas as $row) {
                $key = strtolower(preg_replace('/[^a-z0-9]/', '', $row['area']));
                if (!isset($lookup[$key])) continue;

                $loc       = $lookup[$key];
                $mapData[] = [
                    'area'   => $row['area'],
                    'state'  => $row['state'],
                    'city'   => $row['city'],
                    'status' => $row['status'],
                    'lat'    => (float) $loc['latitude'],
                    'lng'    => (float) $loc['longitude'],
                ];
            }

            Log::info('NMS Map built', [
                'total_areas' => count($rawAreas),
                'mapped'      => count($mapData),
            ]);

        } catch (\Exception $e) {
            Log::error('NMS map data error', ['error' => $e->getMessage()]);
        }

        return $mapData;
    }
}
