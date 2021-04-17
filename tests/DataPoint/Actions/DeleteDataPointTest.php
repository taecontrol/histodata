<?php

namespace Taecontrol\Histodata\Tests\DataPoint\Actions;

use Taecontrol\Histodata\DataPoint\Actions\DeleteDataPoint;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\Tests\TestCase;

class DeleteDataPointTest extends TestCase
{
    /** @test */
    public function it_deletes_data_point_from_db(): void
    {
        $dataPoint = DataPoint::factory()->create();

        (new DeleteDataPoint())->execute($dataPoint);

        $this->assertDeleted($dataPoint);
    }
}
