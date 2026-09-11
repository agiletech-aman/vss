<?php

namespace Tests\Unit;

use App\Services\MasterAlertService;
use PHPUnit\Framework\TestCase;

class MasterAlertServiceTest extends TestCase
{
    public function test_normalizeSelectableValues_flattens_nested_arrays_to_strings(): void
    {
        $service = new MasterAlertService();

        $values = [
            ['name' => 'North Zone'],
            ['label' => 'South Zone'],
            'Central Zone',
            ['value' => 'East Zone'],
        ];

        $this->assertSame([
            'North Zone',
            'South Zone',
            'Central Zone',
            'East Zone',
        ], $service->normalizeSelectableValues($values));
    }
}
