<?php

namespace Taecontrol\Histodata\Tests\VirtualDataSource;

use Illuminate\Support\Facades\Cache;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\PointValue\Enums\PointValueType;
use Taecontrol\Histodata\PointValue\Models\NumericPointValue;
use Taecontrol\Histodata\Tests\TestCase;
use Taecontrol\Histodata\VirtualDataSource\VirtualDataSourceHandler;

class VirtualDataSourceHandlerTest extends TestCase
{
    /** @test */
    public function it_stores_numeric_values_from_a_poll(): void
    {
        $dataSource = DataSource::factory()->create();

        $dataPoints = DataPoint::factory()
            ->count(3)
            ->create([
                'data_source_id' => $dataSource->id,
                'data_type' => PointValueType::NUMERIC(),
            ]);

        $dataPointHandler = new VirtualDataSourceHandler();

        $dataPointHandler->executePoll($dataSource);

        $pointValues = NumericPointValue::all();

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
            ->count(3)
            ->create([
                'data_source_id' => $dataSource->id,
                'data_type' => PointValueType::NUMERIC(),
            ]);

        DataPoint::factory()
            ->count(3)
            ->create([
                'data_source_id' => $dataSource->id,
                'data_type' => PointValueType::NUMERIC(),
                'enabled' => false,
            ]);

        $dataPointHandler = new VirtualDataSourceHandler();

        $dataPointHandler->executePoll($dataSource);

        $pointValues = NumericPointValue::all();

        $dataPointIds = $dataPoints->pluck('id');

        $this->assertCount(3, $pointValues);
        $this->assertContains($pointValues[0]->data_point_id, $dataPointIds);
        $this->assertContains($pointValues[1]->data_point_id, $dataPointIds);
        $this->assertContains($pointValues[2]->data_point_id, $dataPointIds);
    }

    /** @test */
    public function it_stores_initial_value_only_one_time(): void
    {
        $dataSource = DataSource::factory()->create();

        $dataPoint = DataPoint::factory()
            ->create([
                'data_source_id' => $dataSource->id,
                'data_type' => PointValueType::NUMERIC(),
                'configuration' => [
                    'model_type' => 'VIRTUAL',
                    'change_type' => 'random',
                    'initial_value' => 50.5,
                    'min' => 0,
                    'max' => 100,
                    'max_change' => 0.5
                ]
            ]);

        $dataPointHandler = new VirtualDataSourceHandler();

        $dataPointHandler->executePoll($dataSource);
        $pointValue = $dataPoint->lastPointValue();
        $this->assertEquals(50.5, $pointValue->value);

        Cache::put("{$dataSource->id}_last_poll_at", now());

        $this->travel(1)->seconds();

        $dataPointHandler->executePoll($dataSource);
        $pointValue = $dataPoint->lastPointValue();
        $this->assertNotEquals(50.5, $pointValue->value);
    }
}
