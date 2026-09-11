<?php
// ═══════════════════════════════════════════════════════════════
// FILE: app/Services/MasterAlertSummaryService.php
// ═══════════════════════════════════════════════════════════════

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MasterAlertSummaryService
{
    public function totalsForFilters(
        array $summary,
        int $deviceTypeId,
        array $states = [],
        array $locations = [],
        $selectedState = null,
        $selectedLocation = null
    ): array {
        $device = $deviceTypeId === GasAlertService::DEVICE_PH3 ? 'PH3' : 'CO2';

        if (($selectedState === null || $selectedState === '')
            && ($selectedLocation === null || $selectedLocation === '')) {
            $overall = $summary['overall'] ?? [];
            $totals = [
                'normal' => (int) ($overall["totalNormal{$device}"] ?? 0),
                'severe' => (int) ($overall["totalSevere{$device}"] ?? 0),
                'critical' => (int) ($overall["totalCritical{$device}"] ?? 0),
            ];

            return $totals + ['total' => array_sum($totals)];
        }

        $stateName = $this->selectedName($states, $selectedState);
        $locationName = $this->selectedName($locations, $selectedLocation);
        $totals = ['normal' => 0, 'severe' => 0, 'critical' => 0];

        foreach (($summary['locationWise'] ?? []) as $locationSummary) {
            if (!is_array($locationSummary)) {
                continue;
            }

            if ($stateName !== null
                && strcasecmp(trim((string) ($locationSummary['state'] ?? '')), $stateName) !== 0) {
                continue;
            }

            if ($locationName !== null
                && strcasecmp(trim((string) ($locationSummary['locationName'] ?? '')), $locationName) !== 0) {
                continue;
            }

            $totals['normal'] += (int) ($locationSummary["normal{$device}"] ?? 0);
            $totals['severe'] += (int) ($locationSummary["severe{$device}"] ?? 0);
            $totals['critical'] += (int) ($locationSummary["critical{$device}"] ?? 0);
        }

        return $totals + ['total' => array_sum($totals)];
    }

    private function selectedName(array $options, $selectedId): ?string
    {
        if ($selectedId === null || $selectedId === '') {
            return null;
        }

        foreach ($options as $option) {
            if (is_array($option)) {
                $id = $option['base_id'] ?? $option['id'] ?? null;
                if ((string) $id === (string) $selectedId) {
                    return trim((string) ($option['name']
                        ?? $option['stateName']
                        ?? $option['locationName']
                        ?? $option['state']
                        ?? $option['location']
                        ?? ''));
                }
            } elseif ((string) $option === (string) $selectedId) {
                return trim((string) $option);
            }
        }

        // Some API variants submit names directly instead of numeric base IDs.
        return is_numeric($selectedId) ? null : trim((string) $selectedId);
    }

    public function fetchSummary()
    {
        $ttl = config('external-apis.cache_co2_summary', 120);

        return Cache::remember('master_alert_summary', $ttl, function () {
            try {
                $url     = config('external-apis.co2_summary');
                $timeout = config('external-apis.timeout_slow', 30);

                $response = Http::timeout($timeout)
                    ->retry(2, 2000)
                    ->get($url);

                if ($response->failed()) {
                    Log::error('Master Alert Summary Failed', ['url' => $url]);
                    return [];
                }

                return $response->json() ?? [];

            } catch (\Exception $e) {
                Log::error('Master Alert Summary Error', ['message' => $e->getMessage()]);
                return [];
            }
        });
    }
}
