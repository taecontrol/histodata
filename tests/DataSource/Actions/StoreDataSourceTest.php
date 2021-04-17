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

        $newDataSource = DataSource::find($dataSourceDTO->id);

        $this->assertEquals(
            $dataSourceDTO->toArray(),
            [
                'id' => $newDataSource->id,
                'name' => $newDataSource->name,
                'polling' => $newDataSource->polling,
                'configuration' => [
                    'model_type' => $newDataSource->configuration['model_type'],
                ],
            ]
        );
    }
}
