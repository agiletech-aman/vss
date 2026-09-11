<?php

// ═══════════════════════════════════════════════════════════════
// FILE: app/Services/CameraAlertService.php
// ═══════════════════════════════════════════════════════════════

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CameraAlertService
{
    private function alertsUrl(): string
    {
        return config('external-apis.camera_alerts');
    }

    private function statesUrl(): string
    {
        return config('external-apis.master_alert_states');
    }

    private function locationsUrl(string $state): string
    {
        return config('external-apis.master_alert_states') . '/' . rawurlencode($state) . '/locations';
    }

    public function fetch(
        int $page = 1,
        int $size = 20,
        ?string $location  = null,
        ?string $alertType = null,
        ?string $state     = null
    ): array {
        try {
            $params = ['pageNumber' => $page, 'pageSize' => $size];
            if ($location)  $params['location']  = $location;
            if ($alertType) $params['alertType']  = $alertType;
            if ($state)     $params['state']      = $state;

            $timeout  = config('external-apis.timeout_default', 20);
            $response = Http::timeout($timeout)
                ->withoutVerifying()
                ->get($this->alertsUrl(), $params);

            if (!$response->successful()) {
                Log::error('Camera Alert API failed', ['status' => $response->status()]);
                return ['data' => [], 'totalCount' => 0];
            }

            return $response->json();

        } catch (\Exception $e) {
            Log::error('Camera Alert API error', ['message' => $e->getMessage()]);
            return ['data' => [], 'totalCount' => 0];
        }
    }

    /**
     * Fetch all states from /api/master-alerts/states
     * Returns a flat array: ["Bhopal", "Delhi", ...]
     */
    public function getStates(): array
    {
        try {
            $timeout  = config('external-apis.timeout_default', 20);
            $response = Http::timeout($timeout)
                ->withoutVerifying()
                ->get($this->statesUrl());

            if (!$response->successful()) {
                Log::error('States API failed', ['status' => $response->status()]);
                return [];
            }

            return $response->json() ?? [];

        } catch (\Exception $e) {
            Log::error('States API error', ['message' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Fetch locations for a specific state from /api/master-alerts/states/{state}/locations
     * Returns a flat array: ["Bhopal-1", "Burhapur-1", ...]
     */
    public function getLocationsByState(string $state): array
    {
        try {
            $timeout  = config('external-apis.timeout_default', 20);
            $response = Http::timeout($timeout)
                ->withoutVerifying()
                ->get($this->locationsUrl($state));

            if (!$response->successful()) {
                Log::error('Locations API failed', [
                    'state'  => $state,
                    'status' => $response->status(),
                ]);
                return [];
            }

            return $response->json() ?? [];

        } catch (\Exception $e) {
            Log::error('Locations API error', [
                'state'   => $state,
                'message' => $e->getMessage(),
            ]);
            return [];
        }
    }

    /**
     * Fetch all states and ALL locations (for initial page load dropdowns).
     * Uses Http::pool() to fetch all state-location requests in parallel.
     */
    public function getLocationsAndStates(): array
    {
        try {
            $timeout = config('external-apis.timeout_default', 20);

            // ── Step 1: Fetch all states ──────────────────────────────
            $statesResponse = Http::timeout($timeout)
                ->withoutVerifying()
                ->get($this->statesUrl());

            if (!$statesResponse->successful()) {
                Log::error('States API failed', ['status' => $statesResponse->status()]);
                return ['locations' => [], 'states' => []];
            }

            $states = $statesResponse->json() ?? [];

            if (empty($states)) {
                return ['locations' => [], 'states' => []];
            }

            // ── Step 2: Fetch locations for all states in parallel ────
            $responses = Http::pool(function ($pool) use ($states, $timeout) {
                foreach ($states as $state) {
                    $pool->as($state)
                         ->timeout($timeout)
                         ->withoutVerifying()
                         ->get($this->locationsUrl($state));
                }
            });

            $locations = [];

            foreach ($responses as $state => $response) {
                if (
                    $response instanceof \Illuminate\Http\Client\Response
                    && $response->successful()
                ) {
                    $locs      = $response->json() ?? [];
                    $locations = array_merge($locations, $locs);
                } else {
                    Log::warning('Location fetch failed for state', ['state' => $state]);
                }
            }

            $locations = array_values(array_unique($locations));
            sort($locations);

            return [
                'states'    => $states,
                'locations' => $locations,
            ];

        } catch (\Exception $e) {
            Log::error('getLocationsAndStates error', ['message' => $e->getMessage()]);
            return ['locations' => [], 'states' => []];
        }
    }
}
