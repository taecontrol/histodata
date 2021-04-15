<?php


namespace Taecontrol\Histodata\DataSource\Support;

use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceDTO;

abstract class PollingDataSourceHandler extends DataSourceHandler
{
    abstract public function initialize(): void;

    abstract public function executePoll(DataSourceDTO $dataSourceDTO): void;
}
