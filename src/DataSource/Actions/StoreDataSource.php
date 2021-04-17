<?php


namespace Taecontrol\Histodata\DataSource\Actions;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceDTO;
use Taecontrol\Histodata\DataSource\Models\DataSource;

class StoreDataSource
{
    /**
     * @throws UnknownProperties
     */
    public function execute(DataSourceDTO $dataSourceDTO): DataSourceDTO
    {
        $dataSource = DataSource::create([
            'id' => $dataSourceDTO->id,
            'name' => $dataSourceDTO->name,
            'polling' => $dataSourceDTO->polling,
            'configuration' => $dataSourceDTO->configuration->toArray(),
        ]);

        return $dataSource->toDTO();
    }
}
