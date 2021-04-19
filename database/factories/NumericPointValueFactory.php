<?php

namespace Taecontrol\Histodata\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\PointValue\DataTransferObjects\NumericPointValueDTO;
use Taecontrol\Histodata\PointValue\Models\NumericPointValue;


class NumericPointValueFactory extends Factory
{
    protected $model = NumericPointValue::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->randomFloat(nbMaxDecimals: 2),
            'timestamp' => now(),
            'data_point_id' => DataPoint::factory()->create()->id
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function dto(array $attributes = []): NumericPointValueDTO
    {
        $data = $this->state($attributes)->getExpandedAttributes(null);

        return new NumericPointValueDTO(
            value: $data['value'],
            timestamp: $data['timestamp'],
            data_point_id: $data['data_point_id']
        );
    }
}
