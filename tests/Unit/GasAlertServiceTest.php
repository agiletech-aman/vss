<?php

namespace Tests\Unit;

use App\Services\GasAlertService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GasAlertServiceTest extends TestCase
{
    public function test_it_filters_mixed_upstream_rows_by_device_type_id(): void
    {
        Http::fake([
            '*' => Http::response([
                'totalCount' => 3,
                'data' => [
                    ['id' => 1, 'deviceTypeId' => 30001, 'deviceType' => 'PH3', 'alertType' => 'UNKNOWN'],
                    ['id' => 2, 'deviceTypeId' => 30000, 'deviceType' => 'CO2', 'alertType' => 'UNKNOWN'],
                    ['id' => 3, 'deviceTypeId' => 30000, 'deviceType' => 'CO2', 'alertType' => 'NORMAL'],
                ],
            ]),
        ]);

        $result = app(GasAlertService::class)->fetchAlerts([
            'deviceTypeId' => GasAlertService::DEVICE_CO2,
            'pageNumber' => 1,
            'pageSize' => 20,
        ]);

        $this->assertSame([2, 3], array_column($result['data'], 'id'));
        $this->assertTrue($result['filteredLocally']);
    }

    public function test_it_applies_exact_alert_level_after_device_filtering(): void
    {
        Http::fake([
            '*' => Http::response([
                'totalCount' => 3,
                'data' => [
                    ['id' => 1, 'deviceTypeId' => 30000, 'alertType' => 'NORMAL'],
                    ['id' => 2, 'deviceTypeId' => 30000, 'alertType' => 'UNKNOWN'],
                    ['id' => 3, 'deviceTypeId' => 30001, 'alertType' => 'NORMAL'],
                ],
            ]),
        ]);

        $result = app(GasAlertService::class)->fetchAlerts([
            'deviceTypeId' => GasAlertService::DEVICE_CO2,
            'alertType' => 'NORMAL',
            'pageNumber' => 1,
            'pageSize' => 20,
        ]);

        $this->assertSame([1], array_column($result['data'], 'id'));
    }

    public function test_device_name_is_used_when_legacy_rows_have_no_device_type_id(): void
    {
        $service = app(GasAlertService::class);

        $this->assertTrue($service->matchesDeviceType(['deviceType' => 'CO2'], 30000));
        $this->assertTrue($service->matchesDeviceType(['deviceType' => 'PH3'], 30001));
        $this->assertFalse($service->matchesDeviceType(['deviceType' => 'PH3'], 30000));
    }
}
