<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SackCountingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SackController extends Controller
{
    public function index(Request $request, SackCountingService $service)
    {
        $user           = auth()->user();
        $warehouseNames = $user->getAccessibleWarehouseNames();

        $regionId    = $request->get('region_id');
        $warehouseId = $request->get('warehouse_id');

        $fromDate = $request->get('from_date');
        $toDate   = $request->get('to_date');

        $records    = collect();
        $totalCount = 0;

        if ($regionId && $warehouseId) {

            $filters = array_filter([
                'region_id'    => $regionId,
                'warehouse_id' => $warehouseId,
                'from_date'    => $fromDate ?: null,
                'to_date'      => $toDate   ?: null,
                'limit'        => 9999,
            ]);

            $response = $service->fetch($filters);
            $records  = collect(is_array($response) ? $response : ($response['logs'] ?? []));
            $records  = $records->filter(fn ($row) => !empty($row['DateTime_of_action']));

            Log::info('Sack Filter Debug', [
                'user_email'                  => $user->email,
                'from_date'                   => $fromDate,
                'to_date'                     => $toDate,
                'total_records_before_filter' => $records->count(),
            ]);

            if (!$user->hasRole('superadmin') && !$user->hasRole('admin')) {
                $beforeCount     = $records->count();
                $accessibleUpper = array_map(fn ($w) => strtoupper(trim($w)), $warehouseNames);
                $records = $records->filter(function ($row) use ($accessibleUpper) {
                    $warehouse = $row['warehouse_code'] ?? $row['warehouse_name'] ?? $row['warehouse'] ?? null;
                    if (!$warehouse) return false;
                    return in_array(strtoupper(trim($warehouse)), $accessibleUpper);
                });
                Log::info('After Sack Filter', ['before_count' => $beforeCount, 'after_count' => $records->count()]);
            }

            if ($fromDate && $toDate) {
                $from = Carbon::parse($fromDate, 'Asia/Kolkata')->startOfDay();
                $to   = Carbon::parse($toDate,   'Asia/Kolkata')->endOfDay();
                $records = $records->filter(function ($row) use ($from, $to) {
                    try {
                        $dt = Carbon::parse($row['DateTime_of_action'])->setTimezone('Asia/Kolkata');
                        return $dt->between($from, $to);
                    } catch (\Exception $e) { return false; }
                });
            }

            $records = $records
                ->groupBy(function ($item) {
                    $date = Carbon::parse($item['DateTime_of_action'])->setTimezone('Asia/Kolkata')->format('Y-m-d');
                    return $date . '_' . ($item['region_name'] ?? '') . '_' . ($item['warehouse_code'] ?? '')
                        . '_' . ($item['godown_name'] ?? '') . '_' . ($item['compartment_name'] ?? '');
                })
                ->map(function ($group) {
                    $latest = $group->sortByDesc(fn ($item) => Carbon::parse($item['DateTime_of_action'])->timestamp)->first();
                    $dt     = Carbon::parse($latest['DateTime_of_action'])->setTimezone('Asia/Kolkata');
                    return [
                        'date'          => $dt->format('Y-m-d'),
                        'timestamp'     => $dt->timestamp,
                        'region'        => $latest['region_name']      ?? '-',
                        'warehouse'     => $latest['warehouse_code']   ?? '-',
                        'godown'        => $latest['godown_name']      ?? '-',
                        'compartment'   => $latest['compartment_name'] ?? '-',
                        'Day_Total_In'  => $latest['Day_Total_In']     ?? 0,
                        'Day_Total_Out' => $latest['Day_Total_Out']    ?? 0,
                    ];
                })
                ->sortByDesc('timestamp')
                ->values();

            $totalCount = $records->count();
        }

        return view('iot.sack', [
            'records'  => $records,
            'total'    => $totalCount,
            'fromDate' => $fromDate,
            'toDate'   => $toDate,
        ]);
    }

    /**
     * GET /api/sack/region-summary
     * Returns aggregated bag IN/OUT totals per region + warehouses for drill-down.
     */
    public function regionSummary()
    {
        try {
            $data = Cache::remember('sack_region_count_with_wh', 300, function () {

                $url = config(
                    'external-apis.sack_region_count',
                    'https://frsbag.cwcnewiot.in/sack/region-sack-count'
                );

                $response = Http::timeout(15)
                    ->withoutVerifying()
                    ->withHeaders(['Accept' => 'application/json'])
                    ->get($url);

                if (!$response->successful()) {
                    Log::warning('Sack region count failed', ['status' => $response->status()]);
                    return [];
                }

                $raw = $response->json();
                if (!is_array($raw)) return [];

                $merged = [];
                foreach ($raw as $row) {
                    $name = trim($row['region'] ?? '');
                    if (!$name || in_array($name, ['Default_Region', 'gh'])) continue;

                    $key = strtoupper($name);

                    if (!isset($merged[$key])) {
                        $merged[$key] = [
                            'region'         => $key,
                            'region_id'      => $row['region_id'] ?? null,
                            'total_in_bags'  => (int) ($row['total_in_bags']  ?? 0),
                            'total_out_bags' => (int) ($row['total_out_bags'] ?? 0),
                            'net_bags'       => (int) ($row['net_bags']       ?? 0),
                            'last_action_at' => $row['last_action_at']        ?? null,
                            'warehouses'     => $row['warehouses']            ?? [],
                        ];
                    } else {
                        $merged[$key]['total_in_bags']  += (int) ($row['total_in_bags']  ?? 0);
                        $merged[$key]['total_out_bags'] += (int) ($row['total_out_bags'] ?? 0);
                        $merged[$key]['net_bags']       += (int) ($row['net_bags']       ?? 0);

                        // Merge warehouses
                        $existing = $merged[$key]['warehouses'] ?? [];
                        $incoming = $row['warehouses'] ?? [];
                        $merged[$key]['warehouses'] = array_merge($existing, $incoming);

                        $existingTs = $merged[$key]['last_action_at'];
                        $incomingTs = $row['last_action_at'] ?? null;
                        if ($incomingTs && (!$existingTs || $incomingTs > $existingTs)) {
                            $merged[$key]['last_action_at'] = $incomingTs;
                        }
                    }
                }

                $result = array_values($merged);
                usort($result, fn ($a, $b) =>
                    ($b['total_in_bags'] + $b['total_out_bags']) - ($a['total_in_bags'] + $a['total_out_bags'])
                );

                Log::info('Sack region summary loaded', ['regions' => count($result)]);
                return $result;
            });

            return response()->json(['success' => true, 'data' => $data]);

        } catch (\Exception $e) {
            Log::error('Sack region summary error', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'data' => [], 'error' => $e->getMessage()]);
        }
    }

    /**
     * GET /iot/sack/regions
     * Only return regions that have sack movement data.
     */
    public function regions(): \Illuminate\Http\JsonResponse
    {
        $regions = Cache::remember('sack_active_regions', 300, function () {
            $url = config('external-apis.sack_region_count', 'https://frsbag.cwcnewiot.in/sack/region-sack-count');
            $response = Http::timeout(15)->withoutVerifying()->get($url);
            if (!$response->successful()) return [];
            $raw = $response->json();
            if (!is_array($raw)) return [];

            return collect($raw)
                ->filter(fn($r) => !empty($r['region']) && !in_array($r['region'], ['Default_Region', 'gh']))
                ->filter(fn($r) => ($r['total_in_bags'] ?? 0) + ($r['total_out_bags'] ?? 0) > 0)
                ->map(fn($r) => [
                    'id'          => $r['region_id'] ?? null,
                    'region_id'   => $r['region_id'] ?? null,
                    'region_name' => $r['region'],
                    'name'        => $r['region'],
                ])
                ->values()
                ->toArray();
        });

        return response()->json($regions);
    }

    /**
     * GET /iot/sack/warehouses
     * Only return warehouses that have sack movement data.
     */
    public function warehouses(): \Illuminate\Http\JsonResponse
    {
        $warehouses = Cache::remember('sack_active_warehouses', 300, function () {
            $url = config('external-apis.sack_region_count', 'https://frsbag.cwcnewiot.in/sack/region-sack-count');
            $response = Http::timeout(15)->withoutVerifying()->get($url);
            if (!$response->successful()) return [];
            $raw = $response->json();
            if (!is_array($raw)) return [];

            $result = [];
            foreach ($raw as $region) {
                foreach ($region['warehouses'] ?? [] as $wh) {
                    if (($wh['total_in_bags'] ?? 0) + ($wh['total_out_bags'] ?? 0) == 0) continue;
                    $result[] = [
                        'id'             => $wh['warehouse_id'],
                        'warehouse_id'   => $wh['warehouse_id'],
                        'warehouse_name' => $wh['warehouse_name'],
                        'name'           => $wh['warehouse_name'],
                        'region_id'      => $region['region_id'] ?? null,
                        'region_name'    => $region['region']    ?? null,
                    ];
                }
            }
            return $result;
        });

        return response()->json($warehouses);
    }

}
