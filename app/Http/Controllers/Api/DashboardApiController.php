<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardApiController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Get dashboard stats with optional filters
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStats(Request $request)
    {
        try {
            $region = $request->input('region');
            $warehouse = $request->input('warehouse');
            $days = $request->input('days', 30);

            Log::info('Dashboard stats requested', [
                'region' => $region,
                'warehouse' => $warehouse,
                'days' => $days
            ]);

            // Get all data from existing DashboardService
            $data = $this->dashboardService->getStats();

            // Apply filters if specified
            if ($region || $warehouse) {
                $data = $this->applyFilters($data, $region, $warehouse, $days);
            }

            return response()->json([
                'success' => true,
                'data' => $data,
                'filters' => [
                    'region' => $region,
                    'warehouse' => $warehouse,
                    'days' => $days
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Dashboard stats error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to load dashboard data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get warehouses for a specific region
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWarehouses(Request $request)
    {
        try {
            $region = $request->input('region');

            if (!$region) {
                return response()->json([
                    'success' => false,
                    'message' => 'Region parameter is required'
                ], 400);
            }

            Log::info('Getting warehouses for region', ['region' => $region]);

            // Get all dashboard data
            $allData = $this->dashboardService->getStats();

            // DEBUG: Log all mapData to see what we have
            Log::info('All mapData', [
                'total_count' => count($allData['mapData'] ?? []),
                'sample_data' => array_slice($allData['mapData'] ?? [], 0, 3)
            ]);

            $warehouses = [];

            // Extract REAL warehouses from mapData (this has actual warehouse/area names)
            if (isset($allData['mapData']) && is_array($allData['mapData'])) {
                // Filter map data for this region/state
                $regionMapData = array_filter($allData['mapData'], function($m) use ($region) {
                    $matches = ($m['state'] ?? '') === $region;
                    if (!$matches) {
                        // DEBUG: Log non-matching states to help debug
                        Log::debug('State mismatch', [
                            'looking_for' => $region,
                            'found' => $m['state'] ?? 'null',
                            'area' => $m['area'] ?? 'null'
                        ]);
                    }
                    return $matches;
                });

                Log::info('Found map data for region', [
                    'region' => $region,
                    'count' => count($regionMapData),
                    'data' => array_values($regionMapData)
                ]);

                // Extract unique warehouse/area names
                foreach ($regionMapData as $m) {
                    $warehouseName = $m['area'] ?? null;
                    if ($warehouseName) {
                        $warehouses[] = [
                            'id' => $warehouseName, // Use area name as ID
                            'name' => $warehouseName
                        ];
                    }
                }

                // Remove duplicates by name
                $uniqueWarehouses = [];
                $seen = [];
                foreach ($warehouses as $w) {
                    if (!in_array($w['name'], $seen)) {
                        $uniqueWarehouses[] = $w;
                        $seen[] = $w['name'];
                    }
                }
                $warehouses = $uniqueWarehouses;
            }

            // Sort alphabetically
            usort($warehouses, function($a, $b) {
                return strcasecmp($a['name'], $b['name']);
            });

            Log::info('Returning warehouses', [
                'region' => $region,
                'count' => count($warehouses),
                'warehouses' => $warehouses
            ]);

            return response()->json([
                'success' => true,
                'data' => $warehouses,
                'region' => $region
            ]);

        } catch (\Exception $e) {
            Log::error('Get warehouses error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load warehouses',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Apply filters to dashboard data
     *
     * @param array $data
     * @param string|null $region
     * @param string|null $warehouse
     * @param int $days
     * @return array
     */
    private function applyFilters(array $data, $region = null, $warehouse = null, $days = 30): array
    {
        $filtered = $data;

        // Filter regionData by selected region
        if ($region) {
            // Filter region data
            $filtered['regionData'] = collect($data['regionData'] ?? [])
                ->filter(fn($r) => $r['region'] === $region)
                ->values()
                ->toArray();

            // Recalculate camera totals from filtered regions
            if (!empty($filtered['regionData'])) {
                $totals = $this->recalculateTotals($filtered['regionData']);
                $filtered['cameraTotal'] = $totals['total'];
                $filtered['cameraOnline'] = $totals['online'];
                $filtered['cameraOffline'] = $totals['offline'];
            } else {
                $filtered['cameraTotal'] = 0;
                $filtered['cameraOnline'] = 0;
                $filtered['cameraOffline'] = 0;
            }

            // Filter map data by region/state
            $filtered['mapData'] = collect($data['mapData'] ?? [])
                ->filter(fn($m) => ($m['state'] ?? '') === $region)
                ->values()
                ->toArray();
        }

        // Filter by warehouse/area if specified
        if ($warehouse && !empty($filtered['mapData'])) {
            // Filter map data by warehouse/area name
            $filtered['mapData'] = collect($filtered['mapData'] ?? [])
                ->filter(fn($m) => ($m['area'] ?? '') === $warehouse)
                ->values()
                ->toArray();

            Log::info('Filtered by warehouse', [
                'warehouse' => $warehouse,
                'remaining_markers' => count($filtered['mapData'])
            ]);
        }

        // Recalculate map summary
        $filtered['totalSites'] = count($filtered['mapData']);
        $filtered['healthySites'] = count(array_filter($filtered['mapData'], fn($m) => ($m['status'] ?? '') === 'Healthy'));
        $filtered['downSites'] = count(array_filter($filtered['mapData'], fn($m) => ($m['status'] ?? '') === 'Down'));

        // Note: Time-based filtering (days) would require timestamps in the API responses
        // For now, we're using the data as-is from the cache
        // If you need time filtering, you'll need to add timestamps to your API responses

        return $filtered;
    }

    /**
     * Recalculate totals from filtered region data
     *
     * @param array $regionData
     * @return array
     */
    private function recalculateTotals(array $regionData): array
    {
        $total = 0;
        $online = 0;
        $offline = 0;

        foreach ($regionData as $region) {
            $total += $region['total_cameras'] ?? 0;
            $online += $region['online_cameras'] ?? 0;
            $offline += $region['offline_cameras'] ?? 0;
        }

        return [
            'total' => $total,
            'online' => $online,
            'offline' => $offline
        ];
    }
}


