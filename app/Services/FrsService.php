<?php
// ═══════════════════════════════════════════════════════════════
// FILE: app/Services/FrsService.php
// ═══════════════════════════════════════════════════════════════

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FrsService
{
    private function baseUrl(): string
    {
        return config('external-apis.frs_base');
    }

    public function regions(): array
    {
        try {
            $timeout = config('external-apis.timeout_fast', 10);
            $response = Http::timeout($timeout)->get($this->baseUrl() . '/master_regions');

            if (!$response->successful()) {
                Log::error('FRS Regions API failed', ['status' => $response->status()]);
                return [];
            }
            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error('FRS Regions API error', ['message' => $e->getMessage()]);
            return [];
        }
    }

    public function warehouses(): array
    {
        try {
            $timeout = config('external-apis.timeout_fast', 10);
            $response = Http::timeout($timeout)->get($this->baseUrl() . '/master_warehouses');

            if (!$response->successful()) {
                Log::error('FRS Warehouse API failed', ['status' => $response->status()]);
                return [];
            }
            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error('FRS Warehouse API error', ['message' => $e->getMessage()]);
            return [];
        }
    }

    public function fetch(array $filters = []): array
{
    try {
        // A 10,000-record response is roughly 6.5 MB and can take more than
        // the fast 10-second API timeout. Use the slow timeout so an
        // intermittent network delay does not turn a valid response into an
        // empty table.
        $timeout  = config('external-apis.timeout_slow', 30);
        $params   = array_filter($filters); // remove nulls/empty strings

        $response = Http::acceptJson()
            ->connectTimeout(5)
            ->timeout($timeout)
            ->get($this->baseUrl() . '/detection_logs', $params);

        if (!$response->successful()) {
            Log::error('FRS Detection Log API failed', [
                'status'  => $response->status(),
                'filters' => $params,
            ]);
            return ['logs' => []];
        }

        $data = $response->json();

        Log::info('FRS API Response', [
            'filters'    => $params,
            'log_count'  => count($data['logs'] ?? []),
            'keys'       => array_keys($data ?? []),
        ]);

        return $data ?? ['logs' => []];

    } catch (\Exception $e) {
        Log::error('FRS Detection Log API error', ['message' => $e->getMessage()]);
        return ['logs' => []];
    }
}

    public function unknownCount(): int
    {
        try {
            $response = $this->fetch();
            $logs = collect($response['logs'] ?? []);

            return $logs->filter(function ($log) {
                if (isset($log['name'])) {
                    return empty($log['name']) || strtolower($log['name']) === 'unknown';
                }
                if (isset($log['person_type'])) {
                    return strtolower($log['person_type']) === 'unknown';
                }
                return false;
            })->count();
        } catch (\Exception $e) {
            Log::error('FRS Unknown Count error', ['message' => $e->getMessage()]);
            return 0;
        }
    }
}

