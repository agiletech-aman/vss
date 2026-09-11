<?php

namespace Tests\Unit;

use App\Services\MasterAlertSummaryService;
use PHPUnit\Framework\TestCase;

class MasterAlertSummaryServiceTest extends TestCase
{
    private array $summary = [
        'overall' => [
            'totalNormalCO2' => 100,
            'totalSevereCO2' => 20,
            'totalCriticalCO2' => 5,
            'totalNormalPH3' => 80,
            'totalSeverePH3' => 4,
            'totalCriticalPH3' => 6,
        ],
        'locationWise' => [
            'ONE-NORTH' => [
                'state' => 'North',
                'locationName' => 'One',
                'normalCO2' => 30,
                'severeCO2' => 2,
                'criticalCO2' => 1,
                'normalPH3' => 20,
                'severePH3' => 1,
                'criticalPH3' => 2,
            ],
            'TWO-NORTH' => [
                'state' => 'North',
                'locationName' => 'Two',
                'normalCO2' => 40,
                'severeCO2' => 3,
                'criticalCO2' => 2,
                'normalPH3' => 25,
                'severePH3' => 0,
                'criticalPH3' => 1,
            ],
        ],
    ];

    public function test_overall_totals_are_separated_by_device_type(): void
    {
        $service = new MasterAlertSummaryService();

        $this->assertSame(
            ['normal' => 100, 'severe' => 20, 'critical' => 5, 'total' => 125],
            $service->totalsForFilters($this->summary, 30000)
        );
        $this->assertSame(
            ['normal' => 80, 'severe' => 4, 'critical' => 6, 'total' => 90],
            $service->totalsForFilters($this->summary, 30001)
        );
    }

    public function test_totals_follow_selected_state_and_location_ids(): void
    {
        $service = new MasterAlertSummaryService();
        $states = [['base_id' => 7, 'name' => 'North']];
        $locations = [
            ['base_id' => 10, 'name' => 'One'],
            ['base_id' => 11, 'name' => 'Two'],
        ];

        $this->assertSame(
            ['normal' => 70, 'severe' => 5, 'critical' => 3, 'total' => 78],
            $service->totalsForFilters($this->summary, 30000, $states, $locations, 7)
        );
        $this->assertSame(
            ['normal' => 25, 'severe' => 0, 'critical' => 1, 'total' => 26],
            $service->totalsForFilters($this->summary, 30001, $states, $locations, 7, 11)
        );
    }
}
