<?php

namespace Taecontrol\Histodata\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\PointValue\DataTransferObjects\BinaryPointValueDTO;
use Taecontrol\Histodata\PointValue\Models\BinaryPointValue;


class BinaryPointValueFactory extends Factory
{
    protected $model = BinaryPointValue::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->boolean,
            'timestamp' => now(),
            'data_point_id' => DataPoint::factory()->create()->id
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function dto(array $attributes = []): BinaryPointValueDTO
    {
        $data = $this->state($attributes)->getExpandedAttributes(null);

        return new BinaryPointValueDTO(
            value: $data['value'],
            timestamp: $data['timestamp'],
            data_point_id: $data['data_point_id']
        );
    }
}
