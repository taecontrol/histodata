<?php


namespace Taecontrol\Histodata\DataSource\Actions;

use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceDTO;
use Taecontrol\Histodata\DataSource\Models\DataSource;

class StoreDataSource
{
    public function execute(DataSourceDTO $dataSourceDTO): DataSourceDTO
    {
        $dataSource = DataSource::create([
            'name' => $dataSourceDTO->name,
            'enabled' => $dataSourceDTO->enabled,
            'polling' => $dataSourceDTO->polling,
            'configuration' => $dataSourceDTO->configuration->toArray(),
        ]);

        return $dataSource->toDTO();
    }
}
