<?php

namespace Taecontrol\Histodata\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\PointValue\DataTransferObjects\AlphanumericPointValueDTO;
use Taecontrol\Histodata\PointValue\Models\AlphanumericPointValue;


class AlphanumericPointValueFactory extends Factory
{
    protected $model = AlphanumericPointValue::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->word(),
            'timestamp' => now(),
            'data_point_id' => DataPoint::factory()->create()->id
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function dto(array $attributes = []): AlphanumericPointValueDTO
    {
        $data = $this->state($attributes)->getExpandedAttributes(null);

        return new AlphanumericPointValueDTO(
            value: $data['value'],
            timestamp: $data['timestamp'],
            data_point_id: $data['data_point_id']
        );
    }
}
