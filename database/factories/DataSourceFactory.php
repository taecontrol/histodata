<?php

namespace Taecontrol\Histodata\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceDTO;
use Taecontrol\Histodata\DataSource\Models\DataSource;


class DataSourceFactory extends Factory
{
    protected $model = DataSource::class;

    public function definition(): array
    {
        return [
            'id' => Uuid::uuid4()->toString(),
            'name' => $this->faker->words(3, true),
            'configuration' => $this->virtualDataSourceConfiguration()
        ];
    }

    protected function virtualDataSourceConfiguration(): array
    {
        return [
            'model_type' => 'VIRTUAL',
            'polling' => true
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function dto(array $attributes = []): DataSourceDTO
    {
        $data = $this->state($attributes)->getExpandedAttributes(null);

        return new DataSourceDTO(
            id: $data['id'],
            name: $data['name'],
            configuration: $data['configuration']
        );
    }
}
