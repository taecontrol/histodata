<?php

namespace Taecontrol\Histodata\Tests\PointValue\Actions;

use Taecontrol\Histodata\Database\Factories\AlphanumericPointValueFactory;
use Taecontrol\Histodata\PointValue\Actions\StoreAlphanumericPointValue;
use Taecontrol\Histodata\PointValue\Models\AlphanumericPointValue;
use Taecontrol\Histodata\Tests\TestCase;

class StoreAlphanumericPointValueTest extends TestCase
{
    /** @test */
    public function it_stores_alphanumeric_value_into_db(): void
    {
        $alphanumericPointValueDTO = (new AlphanumericPointValueFactory())->dto();

        (new StoreAlphanumericPointValue())->execute($alphanumericPointValueDTO);

        $pointValue = AlphanumericPointValue::query()
            ->where('timestamp', $alphanumericPointValueDTO->timestamp)
            ->first();

        $this->assertEquals(
            $alphanumericPointValueDTO->toArray(),
            [
                'value' => $pointValue->value,
                'timestamp' => $pointValue->timestamp,
                'data_point_id' => $pointValue->data_point_id
            ]
        );
    }
}
