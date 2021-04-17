<?php


namespace Taecontrol\Histodata\DataSource\Actions;


use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceDTO;
use Taecontrol\Histodata\DataSource\Models\DataSource;

class UpdateDataSource
{
    public function execute(DataSource $dataSource, array $updates): DataSourceDTO
    {
        $dataSource->update($updates);

        return $dataSource
            ->refresh()
            ->toDTO();
    }
}