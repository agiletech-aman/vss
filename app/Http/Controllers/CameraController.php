<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CameraController extends Controller
{
    /**
     * Get warehouses by region from camera API
     */
    public function getWarehousesByRegion($region)
    {
        $apiUrl = config('external-apis.camera_by_warehouse');

        try {
            $response = Http::timeout(10)->get($apiUrl);

            if (!$response->successful()) {
                return response()->json(['error' => 'API request failed'], 500);
            }

            $data = $response->json()['data'] ?? [];

            // Filter warehouses by region (case-insensitive)
            $warehouses = collect($data)
                ->filter(function($item) use ($region) {
                    return strtoupper($item['region'] ?? '') === strtoupper($region);
                })
                ->map(function($item) {
                    // Treat unknown cameras as offline
                    $unknownCameras = $item['unknown_cameras'] ?? 0;
                    $offlineCameras = ($item['offline_cameras'] ?? 0) + $unknownCameras;

                    // ✅ FIX: Handle nvr_ips array - get first IP or '-'
                    $nvrIps = $item['nvr_ips'] ?? [];
                    $nvrIp = is_array($nvrIps) && count($nvrIps) > 0 ? $nvrIps[0] : '-';

                    return [
                        'warehouse' => $item['warehouse'] ?? 'Unknown',
                        'nvr_ip' => $nvrIp,  // ✅ Use first IP from array
                        'total_cameras' => $item['total_cameras'] ?? 0,
                        'online_cameras' => $item['online_cameras'] ?? 0,
                        'offline_cameras' => $offlineCameras,
                        'online_percent' => $item['online_percent'] ?? 0,
                        'status' => $item['status'] ?? 'unknown',
                        'nvr_reachable' => $item['nvr_reachable'] ?? false,
                    ];
                })
                // ✅ SORT ALPHABETICALLY (case-insensitive)
                ->sortBy(function($warehouse) {
                    return strtolower($warehouse['warehouse']);
                })
                ->values()
                ->all();

            return response()->json([
                'success' => true,
                'region' => $region,
                'warehouses' => $warehouses,
                'count' => count($warehouses)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch warehouse data',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show warehouse camera details page
     */
    public function warehouseCameraDetails($region, $warehouse)
    {
        $apiUrl = config('external-apis.camera_by_warehouse');

        try {
            $response = Http::timeout(10)->get($apiUrl);

            if (!$response->successful()) {
                abort(500, 'Failed to fetch camera data from API');
            }

            $data = $response->json()['data'] ?? [];

            // Find specific warehouse data
            $warehouseData = collect($data)
                ->first(function($item) use ($region, $warehouse) {
                    return strtoupper($item['region'] ?? '') === strtoupper($region)
                        && strtoupper($item['warehouse'] ?? '') === strtoupper($warehouse);
                });

            if (!$warehouseData) {
                abort(404, 'Warehouse camera data not found');
            }

            // ✅ FIX: Handle nvr_ips array for warehouse details page
            $nvrIps = $warehouseData['nvr_ips'] ?? [];
            $warehouseData['nvr_ip'] = is_array($nvrIps) && count($nvrIps) > 0 ? $nvrIps[0] : '-';

            return view('cameras.warehouse_details', [
                'region' => $region,
                'warehouse' => $warehouse,
                'data' => $warehouseData
            ]);

        } catch (\Exception $e) {
            abort(500, 'Error: ' . $e->getMessage());
        }
    }
}
