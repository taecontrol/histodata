<?php

namespace Taecontrol\Histodata\Tests\DataPoint\Actions;

use Taecontrol\Histodata\DataPoint\Actions\UpdateDataPoint;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\Tests\TestCase;

class UpdateDataSourceTest extends TestCase
{
    /** @test */
    public function it_updates_given_data_point_in_the_db(): void
    {
        $dataPoint = DataPoint::factory()->create();

        $dataPointDTO = (new UpdateDataPoint())->execute($dataPoint, [
            'name' => 'New name',
        ]);

        $this->assertEquals('New name', $dataPointDTO->name);
    }
}
