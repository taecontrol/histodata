<?php

namespace Taecontrol\Histodata\Tests\VirtualDataSource\Actions;

use Ramsey\Uuid\Uuid;
use Taecontrol\Histodata\DataSource\Actions\StoreDataSource;
use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceDTO;
use Taecontrol\Histodata\DataSource\Enums\DataSourceModelType;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\Tests\TestCase;

class StoreDataSourceTest extends TestCase
{
    /** @test */
    public function it_stores_virtual_data_source_in_db()
    {
        $dataSourceDTO = new DataSourceDTO(
            id: Uuid::uuid4()->toString(),
            name: 'Virtual DS Test',
            configuration: [
                'model_type' => DataSourceModelType::VIRTUAL(),
                'polling' => true,
            ]
        );

        (new StoreDataSource())->execute($dataSourceDTO);

        $newDataSource = DataSource::find($dataSourceDTO->id);

        $this->assertEquals(
            $dataSourceDTO->toArray(),
            [
                'id' => $newDataSource->id,
                'name' => $newDataSource->name,
                'configuration' => [
                    'model_type' => $newDataSource->configuration['model_type'],
                    'polling' => $newDataSource->configuration['polling'],
                ],
            ]
        );
    }
}
