<?php

namespace Taecontrol\Histodata\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\DataTransferObjects\DataPointDTO;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\PointValue\Enums\PointValueType;


class DataPointFactory extends Factory
{
    protected $model = DataPoint::class;

    public function definition(): array
    {
        return [
            'id' => Uuid::uuid4()->toString(),
            'name' => $this->faker->words(3, true),
            'enabled' => true,
            'data_source_id' => DataSource::factory()->create()->id,
            'data_type' => $this->faker->randomElement([
                PointValueType::ALPHANUMERIC(),
                PointValueType::NUMERIC(),
                PointValueType::BINARY()
            ]),
            'configuration' => $this->virtualDataPointConfiguration()
        ];
    }

    protected function virtualDataPointConfiguration(): array
    {
        return [
            'model_type' => 'VIRTUAL',
            'change_type' => 'random',
            'initial_value' => 50,
            'min' => 0,
            'max' => 100,
            'max_change' => 0.5
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function dto(array $attributes = []): DataPointDTO
    {
        $data = $this->state($attributes)->getExpandedAttributes(null);

        return new DataPointDTO(
            id: $data['id'],
            name: $data['name'],
            enabled: $data['enabled'],
            data_source_id: $data['data_source_id'],
            data_type: $data['data_type'],
            configuration: $data['configuration']
        );
    }
}
