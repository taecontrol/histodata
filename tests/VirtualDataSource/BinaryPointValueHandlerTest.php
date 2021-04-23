<?php

namespace Taecontrol\Histodata\Tests\VirtualDataSource;

use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\PointValue\Models\BinaryPointValue;
use Taecontrol\Histodata\Tests\TestCase;
use Taecontrol\Histodata\VirtualDataSource\VirtualDataSourceHandler;

class BinaryPointValueHandlerTest extends TestCase
{
    /** @test */
    public function it_stores_binary_values_from_a_poll(): void
    {
        $dataSource = DataSource::factory()->create();

        $dataPoints = DataPoint::factory()
            ->binary()
            ->count(3)
            ->create([
                'data_source_id' => $dataSource->id,
            ]);

        $dataPointHandler = new VirtualDataSourceHandler();

        $dataPointHandler->executePoll($dataSource);

        $pointValues = BinaryPointValue::all();

        $dataPointIds = $dataPoints->pluck('id');

        $this->assertCount(3, $pointValues);
        $this->assertContains($pointValues[0]->data_point_id, $dataPointIds);
        $this->assertContains($pointValues[1]->data_point_id, $dataPointIds);
        $this->assertContains($pointValues[2]->data_point_id, $dataPointIds);
    }

    /** @test */
    public function it_stores_numeric_values_only_for_enabled_data_points(): void
    {
        $dataSource = DataSource::factory()->create();

        $dataPoints = DataPoint::factory()
            ->binary()
            ->count(3)
            ->create([
                'data_source_id' => $dataSource->id,
            ]);

        DataPoint::factory()
            ->count(3)
            ->binary()
            ->create([
                'data_source_id' => $dataSource->id,
                'enabled' => false,
            ]);

        $dataPointHandler = new VirtualDataSourceHandler();

        $dataPointHandler->executePoll($dataSource);

        $pointValues = BinaryPointValue::all();

        $dataPointIds = $dataPoints->pluck('id');

        $this->assertCount(3, $pointValues);
        $this->assertContains($pointValues[0]->data_point_id, $dataPointIds);
        $this->assertContains($pointValues[1]->data_point_id, $dataPointIds);
        $this->assertContains($pointValues[2]->data_point_id, $dataPointIds);
    }
}
