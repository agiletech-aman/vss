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
    private function baseUrl(): string
    {
        return config('external-apis.master_alerts');
    }

    public function normalizeSelectableValues(array $values): array
    {
        return collect($values)
            ->map(fn($value) => $this->normalizeSelectableValue($value))
            ->filter(fn($value) => $value !== '')
            ->values()
            ->all();
    }

    private function normalizeSelectableValue($value): string
    {
        if ($value === null) {
            return '';
        }

        if (is_scalar($value)) {
            return (string) $value;
        }

        if (is_array($value)) {
            foreach (['name', 'label', 'value', 'location', 'locationName', 'state', 'code', 'id'] as $key) {
                if (array_key_exists($key, $value)) {
                    $normalized = $this->normalizeSelectableValue($value[$key]);
                    if ($normalized !== '') {
                        return $normalized;
                    }
                }
            }

            foreach ($value as $item) {
                $normalized = $this->normalizeSelectableValue($item);
                if ($normalized !== '') {
                    return $normalized;
                }
            }

            return '';
        }

        if (is_object($value)) {
            foreach (['name', 'label', 'value', 'location', 'locationName', 'state', 'code', 'id'] as $key) {
                if (property_exists($value, $key)) {
                    $normalized = $this->normalizeSelectableValue($value->{$key});
                    if ($normalized !== '') {
                        return $normalized;
                    }
                }
            }

            foreach ((array) $value as $item) {
                $normalized = $this->normalizeSelectableValue($item);
                if ($normalized !== '') {
                    return $normalized;
                }
            }
        }

        return '';
    }

    public function fetchAlerts(array $params = [])
    {
        try {
            $query = [
                'pageNumber'   => $params['pageNumber']   ?? 1,
                'pageSize'     => $params['pageSize']     ?? 20,
                'deviceTypeId' => $params['deviceTypeId'] ?? null,
                'state'        => $params['state']        ?? null,
                'location'     => $params['location']     ?? null,
                'alertType'    => $params['alertType']    ?? null,
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

        return Cache::remember('master_alert_states', $ttl, function () {
            try {
                $timeout = config('external-apis.timeout_fast', 10);

                $response = Http::timeout($timeout)
                    ->retry(2, 100)
                    ->get($this->baseUrl() . '/states');

                if ($response->failed()) return [];
                return $this->normalizeSelectableValues($response->json() ?? []);

            } catch (\Exception $e) {
                Log::error('Master Alert States Error', ['message' => $e->getMessage()]);
                return [];
            }
        });
    }

    public function locations(string $state)
    {
        $ttl = config('external-apis.cache_locations', 300);

        return Cache::remember('master_alert_locations_' . md5($state), $ttl, function () use ($state) {
            try {
                $timeout = config('external-apis.timeout_fast', 10);

                $response = Http::timeout($timeout)
                    ->retry(2, 100)
                    ->get($this->baseUrl() . '/states/' . urlencode($state) . '/locations');

                if ($response->failed()) return [];
                return $this->normalizeSelectableValues($response->json() ?? []);

            } catch (\Exception $e) {
                Log::error('Master Alert Locations Error', ['message' => $e->getMessage()]);
                return [];
            }
        });
    }
}
