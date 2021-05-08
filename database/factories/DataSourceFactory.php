<?php

namespace Taecontrol\Histodata\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceDTO;
use Taecontrol\Histodata\DataSource\Models\DataSource;


class DataSourceFactory extends Factory
{
    protected $model = DataSource::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'enabled' => true,
            'polling' => true,
            'configuration' => $this->virtualDataSourceConfiguration()
        ];
    }

    protected function virtualDataSourceConfiguration(): array
    {
        return [
            'model_type' => 'VIRTUAL',
            'update_period' => 1,
            'update_period_type' => 'SECONDS'
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function dto(array $attributes = []): DataSourceDTO
    {
        $data = $this->state($attributes)->getExpandedAttributes(null);

        return new DataSourceDTO(
            name: $data['name'],
            enabled: $data['enabled'],
            polling: $data['polling'],
            configuration: $data['configuration']
        );
    }
}
