<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class WarehouseActivityController extends Controller
{
    private string $nmsBase;
    private string $frsBase;
    private string $sackBase;
    private string $iotBase;
    private string $co2SummaryUrl;

    public function __construct()
    {
        $this->nmsBase      = config('external-apis.nms_base',     'https://nms.cwcnewcctv.in/api/nms/v1');
        $this->frsBase      = config('external-apis.frs_base',     'https://frsbag.cwcnewiot.in');
        $this->sackBase     = config('external-apis.sack_base',    'https://frsbag.cwcnewiot.in');
        $this->iotBase      = config('external-apis.iot_base',     'https://co2ph3master.agiletech.net.in');
        $this->co2SummaryUrl= config('external-apis.co2_summary',  '');
    }

    /**
     * Show full activity page for a warehouse.
     * Route: GET /warehouse/{id}/activity
     * Name:  warehouse.activity
     */
    public function index(int $id): View
    {
        return view('warehouse.activity', [
            'warehouseId'   => $id,
            'nmsBase'       => $this->nmsBase,
            'frsBase'       => $this->frsBase,
            'sackBase'      => $this->sackBase,
            'iotBase'       => $this->iotBase,
            'co2SummaryUrl' => $this->co2SummaryUrl,
        ]);
    }

    /**
     * Proxy sack API to avoid CORS.
     * Route: GET /api/proxy/sack
     */
    public function proxySack(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = http_build_query($request->only(['warehouse_id', 'region_id']));
        $url   = rtrim($this->sackBase, '/') . '/sack/data?' . $query;

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)->get($url);
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 502);
        }
    }

    /**
     * Master warehouse overview page — all warehouses, all systems.
     * Route: GET /warehouse/master
     * Name:  warehouse.master
     */
    public function master(): \Illuminate\View\View
    {
        return view('warehouse.master', [
            'nmsBase'       => $this->nmsBase,
            'frsBase'       => $this->frsBase,
            'sackBase'      => $this->sackBase,
            'iotBase'       => $this->iotBase,
            'co2SummaryUrl' => $this->co2SummaryUrl,
        ]);
    }

    /**
     * Proxy FRS detection_logs per warehouse.
     * Route: GET /api/proxy/frs-logs
     */
    public function proxyFrsLogs(Request $request): \Illuminate\Http\JsonResponse
    {
        $warehouseId = $request->get('warehouse_id');
        $limit       = $request->get('limit', 1);
        $url         = rtrim($this->frsBase, '/') . '/frs/detection_logs'
                     . '?warehouse_id=' . $warehouseId
                     . '&limit=' . $limit;
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(8)->get($url);
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 502);
        }
    }
}
