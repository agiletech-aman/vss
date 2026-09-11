<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NmsPagesController extends Controller
{
    private string $nmsBase;

    public function __construct()
    {
        $this->nmsBase = config('external-apis.nms_base',
            config('apis.nms_base', 'https://nms.cwcnewcctv.in/api/nms/v1'));
    }

    public function dashboard()
    {
        return view('nms.dashboard', ['nmsBase' => $this->nmsBase]);
    }

    public function warehouses()
    {
        return view('nms.warehouses', ['nmsBase' => $this->nmsBase]);
    }

    public function regions()
    {
        return view('nms.regions', ['nmsBase' => $this->nmsBase]);
    }

    public function regionDetail(string $region)
    {
        return view('nms.region-detail', [
            'nmsBase' => $this->nmsBase,
            'region'  => $region,
        ]);
    }

    public function warehouseDetail($id)
    {
        return view('nms.warehouse-detail', [
            'nmsBase'     => $this->nmsBase,
            'warehouseId' => $id,
        ]);
    }

    public function map()
    {
        return view('nms.map', ['nmsBase' => $this->nmsBase]);
    }

    public function apiMonitor(): \Illuminate\View\View
{
    return view('nms.api-monitor', [
        'nmsBase'  => $this->nmsBase,
        'frsBase'  => config('external-apis.frs_base',  'https://frsbag.cwcnewiot.in'),
        'sackBase' => config('external-apis.sack_base', 'https://frsbag.cwcnewiot.in'),
        'iotBase'  => config('external-apis.iot_base',  'https://co2ph3master.ajeevi.in'),
    ]);
}
}
