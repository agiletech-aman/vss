<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RegionWarehousesController extends Controller
{
    /**
     * Show all warehouses for a specific region
     */
    public function index($region)
    {
        $apiUrl = config('external-apis.camera_by_warehouse');

        try {
            $response = Http::timeout(10)->get($apiUrl);

            if (!$response->successful()) {
                abort(500, 'Failed to fetch camera data from API');
            }

            $data = $response->json()['data'] ?? [];

            // Group warehouses by name to handle multiple NVRs per warehouse
            $warehouseGroups = [];

            foreach ($data as $item) {
                // Filter by region
                if (strtoupper($item['region'] ?? '') !== strtoupper($region)) {
                    continue;
                }

                $warehouseName = $item['warehouse'] ?? 'Unknown';

                // Initialize warehouse group if not exists
                if (!isset($warehouseGroups[$warehouseName])) {
                    $warehouseGroups[$warehouseName] = [
                        'warehouse' => $warehouseName,
                        'region' => $item['region'] ?? $region,
                        'nvr_count' => 0,
                        'nvr_ips' => [],
                        'total_cameras' => 0,
                        'online_cameras' => 0,
                        'offline_cameras' => 0,
                        'unknown_cameras' => 0,
                    ];
                }

                // Add this NVR's data to the warehouse group
                $nvrIps = $item['nvr_ips'] ?? [];
                $nvrIp = is_array($nvrIps) && count($nvrIps) > 0 ? $nvrIps[0] : ($item['nvr_ip'] ?? '-');

                // Only add unique IPs
                if (!in_array($nvrIp, $warehouseGroups[$warehouseName]['nvr_ips'])) {
                    $warehouseGroups[$warehouseName]['nvr_ips'][] = $nvrIp;
                    $warehouseGroups[$warehouseName]['nvr_count']++;
                }

                // Aggregate camera counts
                $warehouseGroups[$warehouseName]['total_cameras'] += $item['total_cameras'] ?? 0;
                $warehouseGroups[$warehouseName]['online_cameras'] += $item['online_cameras'] ?? 0;
                $warehouseGroups[$warehouseName]['offline_cameras'] += $item['offline_cameras'] ?? 0;
                $warehouseGroups[$warehouseName]['unknown_cameras'] += $item['unknown_cameras'] ?? 0;
            }

            // Convert to array and calculate percentages
            $warehouses = collect($warehouseGroups)->map(function($warehouse) {
                // Treat unknown cameras as offline
                $warehouse['offline_cameras'] += $warehouse['unknown_cameras'];

                // Calculate online percentage
                $warehouse['online_percent'] = $warehouse['total_cameras'] > 0
                    ? round(($warehouse['online_cameras'] / $warehouse['total_cameras']) * 100, 1)
                    : 0;

                // Determine status
                if ($warehouse['online_percent'] >= 70) {
                    $warehouse['status'] = 'ok';
                } elseif ($warehouse['online_percent'] >= 40) {
                    $warehouse['status'] = 'warning';
                } else {
                    $warehouse['status'] = 'alert';
                }

                // Get primary NVR IP for display
                $warehouse['primary_nvr_ip'] = $warehouse['nvr_ips'][0] ?? '-';

                return $warehouse;
            })
            // ✅ Sort alphabetically by warehouse name
            ->sortBy(function($warehouse) {
                return strtolower($warehouse['warehouse']);
            })
            ->values()
            ->all();

            if (empty($warehouses)) {
                abort(404, 'No warehouses found for this region');
            }

            // Calculate region totals
            $regionStats = [
                'total_cameras' => array_sum(array_column($warehouses, 'total_cameras')),
                'online_cameras' => array_sum(array_column($warehouses, 'online_cameras')),
                'offline_cameras' => array_sum(array_column($warehouses, 'offline_cameras')),
                'warehouse_count' => count($warehouses),
                'nvr_count' => array_sum(array_column($warehouses, 'nvr_count')),
            ];

            $regionStats['online_percent'] = $regionStats['total_cameras'] > 0
                ? round(($regionStats['online_cameras'] / $regionStats['total_cameras']) * 100, 1)
                : 0;

            return view('cameras.region_warehouses', [
                'region' => $region,
                'warehouses' => $warehouses,
                'stats' => $regionStats
            ]);

        } catch (\Exception $e) {
            abort(500, 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Show details for a specific warehouse (with multiple NVRs)
     */
    public function show($region, $warehouse)
    {
        try {
            $searchUrl = config('external-apis.camera_warehouse_search');
            $warehouseQuery = urlencode($warehouse);

            Log::info("Fetching warehouse details", [
                'region' => $region,
                'warehouse' => $warehouse,
                'url' => "{$searchUrl}?q={$warehouseQuery}"
            ]);

            // Fetch warehouse data from API
            $response = Http::timeout(30)->get("{$searchUrl}?q={$warehouseQuery}");

            if (!$response->successful()) {
                Log::error("Warehouse API failed", [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return view('cameras.warehouse_details', [
                    'warehouse' => $warehouse,
                    'region' => $region,
                    'error' => 'Failed to fetch warehouse data'
                ]);
            }

            $data = $response->json();

            if (!isset($data['success']) || !$data['success']) {
                Log::warning("Warehouse API returned unsuccessful response", ['data' => $data]);

                return view('cameras.warehouse_details', [
                    'warehouse' => $warehouse,
                    'region' => $region,
                    'error' => 'No data available for this warehouse'
                ]);
            }

            // Get all warehouse entries (multiple NVRs)
            $warehouseEntries = $data['data']['warehouses'] ?? [];

            if (empty($warehouseEntries)) {
                return view('cameras.warehouse_details', [
                    'warehouse' => $warehouse,
                    'region' => $region,
                    'error' => 'No NVR data found for this warehouse'
                ]);
            }

            // Aggregate data across all NVRs
            $totalCameras = 0;
            $onlineCameras = 0;
            $offlineCameras = 0;
            $unknownCameras = 0;
            $nvrs = [];

            foreach ($warehouseEntries as $entry) {
                // Aggregate camera counts
                $totalCameras += $entry['total_cameras'] ?? 0;
                $onlineCameras += $entry['online_cameras'] ?? 0;
                $offlineCameras += $entry['offline_cameras'] ?? 0;
                $unknownCameras += $entry['unknown_cameras'] ?? 0;

                // ✅ FIXED: Always add each NVR entry (removed duplicate IP check)
                // Multiple NVRs can share the same IP (different channels/streams)
                $nvrIp = $entry['nvr_ip'] ?? '-';
                $nvrType = $entry['nvr_type'] ?? 'Unknown';

                $nvrs[] = [
                    'ip' => $nvrIp,
                    'type' => $nvrType,
                    'total_cameras' => $entry['total_cameras'] ?? 0,
                    'online_cameras' => $entry['online_cameras'] ?? 0,
                    'offline_cameras' => $entry['offline_cameras'] ?? 0,
                    'unknown_cameras' => $entry['unknown_cameras'] ?? 0,
                    'online_percent' => $entry['online_percent'] ?? 0,
                    'status' => $entry['status'] ?? 'unknown',
                    'nvr_reachable' => $entry['nvr_reachable'] ?? false,
                    'last_synced_at' => $entry['last_synced_at'] ?? null,
                ];
            }

            // Calculate overall uptime - Use float division
            $uptime = $totalCameras > 0
                ? round((floatval($onlineCameras) / floatval($totalCameras)) * 100, 1)
                : 0;

            // Determine overall status
            $status = 'alert';
            if ($uptime >= 70) {
                $status = 'ok';
            } elseif ($uptime >= 40) {
                $status = 'warning';
            }

            $warehouseData = [
                'warehouse' => $warehouse,
                'region' => $region,
                'total_cameras' => $totalCameras,
                'online_cameras' => $onlineCameras,
                'offline_cameras' => $offlineCameras,
                'unknown_cameras' => $unknownCameras,
                'uptime' => $uptime,
                'status' => $status,
                'nvr_count' => count($nvrs),
                'nvrs' => $nvrs,
            ];

            Log::info("Warehouse details processed successfully", [
                'warehouse' => $warehouse,
                'nvr_count' => count($nvrs),
                'total_cameras' => $totalCameras,
                'uptime' => $uptime
            ]);

            return view('cameras.warehouse_details', [
                'warehouse' => $warehouse,
                'region' => $region,
                'data' => $warehouseData,
                'error' => null
            ]);

        } catch (\Exception $e) {
            Log::error("Exception in warehouse details", [
                'region' => $region,
                'warehouse' => $warehouse,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('cameras.warehouse_details', [
                'warehouse' => $warehouse,
                'region' => $region,
                'error' => 'An error occurred while fetching warehouse data: ' . $e->getMessage()
            ]);
        }
    }
}
