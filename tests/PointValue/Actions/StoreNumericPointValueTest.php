<?php

namespace Taecontrol\Histodata\Tests\PointValue\Actions;

use Taecontrol\Histodata\Database\Factories\NumericPointValueFactory;
use Taecontrol\Histodata\PointValue\Actions\StoreNumericPointValue;
use Taecontrol\Histodata\PointValue\Models\NumericPointValue;
use Taecontrol\Histodata\Tests\TestCase;

class StoreNumericPointValueTest extends TestCase
{
    /** @test */
    public function it_stores_numeric_value_into_db(): void
    {
        $numericPointValueDTO = (new NumericPointValueFactory())->dto();

        (new StoreNumericPointValue())->execute($numericPointValueDTO);

        $pointValue = NumericPointValue::query()
            ->where('timestamp', $numericPointValueDTO->timestamp)
            ->first();

        $this->assertEquals(
            $numericPointValueDTO->toArray(),
            [
                'value' => (float)$pointValue->value,
                'timestamp' => $pointValue->timestamp,
                'data_point_id' => $pointValue->data_point_id,
            ]
        );
    }
}
