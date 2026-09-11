<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NmsService
{
    private string $base;
    private int    $timeout = 10;
    private int    $ttl     = 60;

    public function __construct()
    {
        // Support both config key names
        $this->base = rtrim(
            config('external-apis.nms_base',
                config('apis.nms_base', 'https://nms.cwcnewcctv.in/api/nms/v1')
            ), '/'
        );
    }

    // ── Core fetch ─────────────────────────────────────────────────────
    private function fetch(string $endpoint, array $params = []): array
    {
        $url      = $this->base . $endpoint;
        $cacheKey = 'nms_' . md5($url . json_encode($params));

        return Cache::remember($cacheKey, $this->ttl, function () use ($url, $params) {
            try {
                $resp = Http::timeout($this->timeout)->withoutVerifying()->get($url, $params);
                if ($resp->successful()) {
                    $json = $resp->json();
                    return $json['data'] ?? $json ?? [];
                }
                Log::warning("NMS API error: {$url} — HTTP " . $resp->status());
                return [];
            } catch (\Throwable $e) {
                Log::error("NMS API exception: {$url} — " . $e->getMessage());
                return [];
            }
        });
    }

    // ── Public methods ──────────────────────────────────────────────────

    public function getSummary(): array
    {
        return Cache::remember('nms_summary', $this->ttl, function () {
            try {
                $resp = Http::timeout($this->timeout)->withoutVerifying()->get($this->base . '/summary');
                return $resp->successful() ? ($resp->json('data') ?? []) : [];
            } catch (\Throwable $e) {
                Log::error('NMS summary error: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function getRegions(): array        { return $this->fetch('/regions'); }
    public function getWarehouses(?int $regionId = null): array { return $this->fetch('/warehouses', $regionId ? ['region_id' => $regionId] : []); }
    public function getWarehouseDetail(int $id): array { return $this->fetch("/warehouses/{$id}"); }
    public function getDevices(array $filters = []): array  { return $this->fetch('/devices', $filters); }
    public function getCameras(array $filters = []): array  { return $this->fetch('/cameras', $filters); }
    public function getOfflineAlerts(array $filters = []): array { return $this->fetch('/alerts/offline', $filters); }
    public function getStatsByType(): array    { return $this->fetch('/stats/by-type'); }
    public function getMapPins(): array        { return $this->fetch('/map'); }

    /**
     * Alias used by DashboardService::getNMSMapData()
     * Returns flat array of area rows with status for map rendering.
     */
    public function fetchCameraHealthMap(): array
    {
        $pins = $this->getMapPins();

        // If NMS /map returns warehouse-format pins, normalize to area format
        // that DashboardService expects: [area, state, city, status]
        return collect($pins)->map(function ($pin) {
            return [
                'area'   => $pin['warehouse_name'] ?? $pin['area']   ?? '',
                'state'  => $pin['state']          ?? $pin['region_name'] ?? '',
                'city'   => $pin['city']            ?? '',
                'status' => ucfirst($pin['status']  ?? 'unknown'),
                // Pass through extras for the new NMS map integration
                'lat'          => $pin['lat']          ?? null,
                'lng'          => $pin['lng']          ?? null,
                'warehouse_id' => $pin['warehouse_id'] ?? null,
                'region_name'  => $pin['region_name']  ?? '',
                'nvr_online'   => $pin['nvr_online']   ?? 0,
                'nvr_total'    => $pin['nvr_total']    ?? 0,
                'cam_online'   => $pin['cam_online']   ?? 0,
                'cam_total'    => $pin['cam_total']    ?? 0,
                'bts_clients'  => $pin['bts_clients']  ?? 0,
            ];
        })->values()->toArray();
    }

    // ── ICCC dashboard helpers ──────────────────────────────────────────

    public function getCameraCoverage(): array
    {
        $s = $this->getSummary();
        return [
            'online'       => $s['online_cameras']       ?? 0,
            'total'        => $s['total_cameras']         ?? 0,
            'coverage_pct' => $s['camera_coverage_pct']  ?? 0,
        ];
    }

    public function getTopOfflineWarehouses(int $limit = 10): array
    {
        return collect($this->getWarehouses())
            ->where('status', 'down')
            ->sortByDesc('nvr_offline')
            ->take($limit)
            ->values()
            ->toArray();
    }
}
