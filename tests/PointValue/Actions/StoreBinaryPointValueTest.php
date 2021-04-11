<?php

namespace Taecontrol\Histodata\Tests\PointValue\Actions;

use Taecontrol\Histodata\Database\Factories\BinaryPointValueFactory;
use Taecontrol\Histodata\PointValue\Actions\StoreBinaryPointValue;
use Taecontrol\Histodata\PointValue\Models\BinaryPointValue;
use Taecontrol\Histodata\Tests\TestCase;

class StoreBinaryPointValueTest extends TestCase
{
    /** @test */
    public function it_stores_binary_value_into_db(): void
    {
        $binaryPointValueDTO = (new BinaryPointValueFactory())->dto();

        (new StoreBinaryPointValue())->execute($binaryPointValueDTO);

        $pointValue = BinaryPointValue::query()
            ->where('timestamp', $binaryPointValueDTO->timestamp)
            ->first();

        $this->assertEquals(
            $binaryPointValueDTO->toArray(),
            [
                'value' => $pointValue->value,
                'timestamp' => $pointValue->timestamp,
                'data_point_id' => $pointValue->data_point_id,
            ]
        );
    }
}
