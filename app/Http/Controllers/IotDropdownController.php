<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IotDropdownController extends Controller
{
    /* ==========================
       SACK REGIONS
    ========================== */
    public function sackRegions()
    {
        try {
            $user = auth()->user();
            $timeout = config('external-apis.timeout_fast', 10);

            $response = Http::timeout($timeout)
                ->get(config('external-apis.sack_base') . '/master_regions');

            if (!$response->successful()) {
                Log::error('SACK REGIONS API FAILED', ['status' => $response->status()]);
                return response()->json([]);
            }

            $data = $response->json();
            $regions = is_array($data) ? $data : ($data['regions'] ?? []);

            // FILTER FOR REGION OFFICERS AND WAREHOUSE OFFICERS
            if ($user->isRegionOfficer() || $user->isWarehouseOfficer()) {
                $userRegion = null;
                if ($user->region_id) {
                    $userRegion = $user->region;
                } elseif ($user->warehouse_id && $user->warehouse) {
                    $userRegion = $user->warehouse->region;
                }

                if ($userRegion) {
                    $regions = collect($regions)
                        ->filter(function ($region) use ($userRegion) {
                            $regionName = is_array($region) ? ($region['region_name'] ?? $region['name'] ?? '') : $region;
                            return strtolower(trim($regionName)) === strtolower(trim($userRegion->name));
                        })
                        ->values()
                        ->toArray();
                }
            }

            return response()->json($regions);

        } catch (\Exception $e) {
            Log::error('SACK REGIONS ERROR', ['message' => $e->getMessage()]);
            return response()->json([]);
        }
    }

    /* ==========================
       SACK WAREHOUSES
    ========================== */
    public function sackWarehouses()
    {
        try {
            $user = auth()->user();
            $warehouseNames = $user->getAccessibleWarehouseNames();
            $timeout = config('external-apis.timeout_fast', 10);

            $response = Http::timeout($timeout)
                ->get(config('external-apis.sack_base') . '/master_warehouses');

            if (!$response->successful()) {
                Log::error('SACK WAREHOUSES API FAILED', ['status' => $response->status()]);
                return response()->json([]);
            }

            $data = $response->json();
            $warehouses = is_array($data) ? $data : ($data['warehouses'] ?? []);

            if (!$user->hasRole('superadmin') && !$user->hasRole('admin')) {
                $warehouses = collect($warehouses)
                    ->filter(function ($wh) use ($warehouseNames) {
                        $whName = is_array($wh) ? ($wh['warehouse_name'] ?? $wh['name'] ?? '') : $wh;
                        $whUpper = strtoupper(trim($whName));
                        $accessibleUpper = array_map(fn($w) => strtoupper(trim($w)), $warehouseNames);
                        return in_array($whUpper, $accessibleUpper);
                    })
                    ->values()
                    ->toArray();
            }

            return response()->json($warehouses);

        } catch (\Exception $e) {
            Log::error('SACK WAREHOUSE ERROR', ['message' => $e->getMessage()]);
            return response()->json([]);
        }
    }

    /* ==========================
       FRS REGIONS
    ========================== */
    public function frsRegions()
    {
        try {
            $user = auth()->user();
            $timeout = config('external-apis.timeout_fast', 10);

            $response = Http::timeout($timeout)
                ->get(config('external-apis.frs_base') . '/master_regions');

            if (!$response->successful()) {
                Log::error('FRS REGIONS API FAILED', ['status' => $response->status()]);
                return response()->json([]);
            }

            $data = $response->json();
            $regions = $data['regions'] ?? [];

            if ($user->isRegionOfficer() || $user->isWarehouseOfficer()) {
                $userRegion = null;
                if ($user->region_id) {
                    $userRegion = $user->region;
                } elseif ($user->warehouse_id && $user->warehouse) {
                    $userRegion = $user->warehouse->region;
                }

                if ($userRegion) {
                    $regions = collect($regions)
                        ->filter(function ($region) use ($userRegion) {
                            return strtolower(trim($region['region_name'] ?? '')) === strtolower(trim($userRegion->name));
                        })
                        ->values()
                        ->toArray();
                }
            }

            return response()->json($regions);

        } catch (\Exception $e) {
            Log::error('FRS REGIONS ERROR', ['message' => $e->getMessage()]);
            return response()->json([]);
        }
    }

    /* ==========================
       FRS WAREHOUSES
    ========================== */
    public function frsWarehouses()
    {
        try {
            $user = auth()->user();
            $warehouseNames = $user->getAccessibleWarehouseNames();
            $timeout = config('external-apis.timeout_fast', 10);

            $response = Http::timeout($timeout)
                ->get(config('external-apis.frs_base') . '/master_warehouses');

            if (!$response->successful()) {
                Log::error('FRS WAREHOUSES API FAILED', ['status' => $response->status()]);
                return response()->json([]);
            }

            $data = $response->json();
            $warehouses = $data['warehouses'] ?? [];

            if (!$user->hasRole('superadmin') && !$user->hasRole('admin')) {
                $warehouses = collect($warehouses)
                    ->filter(function ($wh) use ($warehouseNames) {
                        $whName = $wh['warehouse_name'] ?? '';
                        $whUpper = strtoupper(trim($whName));
                        $accessibleUpper = array_map(fn($w) => strtoupper(trim($w)), $warehouseNames);
                        return in_array($whUpper, $accessibleUpper);
                    })
                    ->values()
                    ->toArray();
            }

            return response()->json($warehouses);

        } catch (\Exception $e) {
            Log::error('FRS WAREHOUSE ERROR', ['message' => $e->getMessage()]);
            return response()->json([]);
        }
    }
}
