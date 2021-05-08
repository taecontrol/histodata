<?php

namespace Taecontrol\Histodata\Tests\DataPoint\Actions;

use Taecontrol\Histodata\Database\Factories\DataPointFactory;
use Taecontrol\Histodata\DataPoint\Actions\StoreDataPoint;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\Tests\TestCase;

class StoreDataPointTest extends TestCase
{
    /** @test */
    public function it_stores_data_point_in_db(): void
    {
        $dataPointDTO = (new DataPointFactory())->dto();

        (new StoreDataPoint())->execute($dataPointDTO);

        $newDataPoint = DataPoint::query()
            ->where('name', $dataPointDTO->name)
            ->first();

        $this->assertEquals(
            $dataPointDTO->except('id')->toArray(),
            [
                'name' => $newDataPoint->name,
                'enabled' => $newDataPoint->enabled,
                'data_source_id' => $newDataPoint->data_source_id,
                'data_type' => $newDataPoint->data_type,
                'configuration' => [
                    'model_type' => $newDataPoint->configuration['model_type'],
                    'change_type' => $newDataPoint->configuration['change_type'],
                    'initial_value' => $newDataPoint->configuration['initial_value'],
                    'min' => $newDataPoint->configuration['min'],
                    'max' => $newDataPoint->configuration['max'],
                    'max_change' => $newDataPoint->configuration['max_change'],
                ],
            ]
        );
    }
}
