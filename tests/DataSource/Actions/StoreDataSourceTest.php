<?php

namespace Taecontrol\Histodata\Tests\DataSource\Actions;

use Taecontrol\Histodata\Database\Factories\DataSourceFactory;
use Taecontrol\Histodata\DataSource\Actions\StoreDataSource;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\Tests\TestCase;

class StoreDataSourceTest extends TestCase
{
    /** @test */
    public function it_stores_data_source_in_db(): void
    {
        $dataSourceDTO = (new DataSourceFactory())->dto();

        (new StoreDataSource())->execute($dataSourceDTO);

        $newDataSource = DataSource::query()
            ->where('name', $dataSourceDTO->name)
            ->first();

        $this->assertEquals(
            $dataSourceDTO->except('id')->toArray(),
            [
                'name' => $newDataSource->name,
                'enabled' => $newDataSource->enabled,
                'polling' => $newDataSource->polling,
                'configuration' => [
                    'update_period' => $newDataSource->configuration['update_period'],
                    'update_period_type' => $newDataSource->configuration['update_period_type'],
                    'model_type' => $newDataSource->configuration['model_type'],
                ],
            ]
        );
    }
}
