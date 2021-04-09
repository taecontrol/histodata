<?php


namespace Taecontrol\Histodata\DataSource\Actions;


use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceDTO;
use Taecontrol\Histodata\DataSource\Enums\DataSourceModelType;
use Taecontrol\Histodata\VirtualDataSource\Actions\StoreDataSource as StoreVirtualDataSource;

class StoreDataSource
{
    /**
     * @throws UnknownProperties
     */
    public function execute(DataSourceDTO $dataSourceDTO): DataSourceDTO | null
    {
        if (DataSourceModelType::VIRTUAL()->equals($dataSourceDTO->configuration->model_type)) {
            (new StoreVirtualDataSource())->execute($dataSourceDTO);
        }

        return null;
    }
}