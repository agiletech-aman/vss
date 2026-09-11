<?php
// ═══════════════════════════════════════════════════════════════
// FILE: app/Services/MasterAlertService.php
// ═══════════════════════════════════════════════════════════════

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MasterAlertService
{
    private const DEVICE_TYPE_IDS = [30000, 30001];
    private const ALERT_TYPES = ['severe', 'critical', 'normal'];

    private function baseUrl(): string
    {
        return config('external-apis.master_alerts');
    }

    public function fetchAlerts(array $params = [])
    {
        try {
            $deviceTypeId = isset($params['deviceTypeId'])
                && in_array((int) $params['deviceTypeId'], self::DEVICE_TYPE_IDS, true)
                    ? (int) $params['deviceTypeId']
                    : null;

            $alertType = isset($params['alertType'])
                ? strtolower(trim((string) $params['alertType']))
                : null;

            if (!in_array($alertType, self::ALERT_TYPES, true)) {
                $alertType = null;
            }

            $query = [
                'pageNumber'   => $params['pageNumber']   ?? 1,
                'pageSize'     => $params['pageSize']     ?? 20,
                'deviceTypeId' => $deviceTypeId,
                'state'        => $params['state']        ?? null,
                'location'     => $params['location']     ?? null,
                'alertType'    => $alertType,
                'device'       => $params['device']       ?? null,
                'fromDate'     => $params['fromDate']     ?? null,
                'toDate'       => $params['toDate']       ?? null,
                'showNormal'   => $params['showNormal']   ?? null,
            ];

            $timeout = config('external-apis.timeout_default', 20);

            $response = Http::timeout($timeout)
                ->retry(2, 100)
                ->get($this->baseUrl(), array_filter($query, fn($v) => !is_null($v)));

            if ($response->failed()) {
                Log::error('Master Alerts API Failed', ['status' => $response->status()]);
                return ['data' => [], 'totalCount' => 0];
            }

            return $response->json();

        } catch (\Exception $e) {
            Log::error('Master Alerts API Error', ['message' => $e->getMessage()]);
            return ['data' => [], 'totalCount' => 0];
        }
    }

    public function states()
    {
        $ttl = config('external-apis.cache_states', 300);

        return Cache::remember('master_alert_states_v2', $ttl, function () {
            try {
                $timeout = config('external-apis.timeout_fast', 10);

                $response = Http::timeout($timeout)
                    ->retry(2, 100)
                    ->get($this->baseUrl() . '/states');

                if ($response->failed()) return [];
                return $response->json() ?? [];

            } catch (\Exception $e) {
                Log::error('Master Alert States Error', ['message' => $e->getMessage()]);
                return [];
            }
        });
    }

    public function locations(string $state)
    {
        $ttl = config('external-apis.cache_locations', 300);

        return Cache::remember('master_alert_locations_v2_' . md5($state), $ttl, function () use ($state) {
            try {
                $timeout = config('external-apis.timeout_fast', 10);

                $response = Http::timeout($timeout)
                    ->retry(2, 100)
                    ->get($this->baseUrl() . '/states/' . urlencode($state) . '/locations');

                if ($response->failed()) return [];
                return $response->json() ?? [];

            } catch (\Exception $e) {
                Log::error('Master Alert Locations Error', ['message' => $e->getMessage()]);
                return [];
            }
        });
    }
}
