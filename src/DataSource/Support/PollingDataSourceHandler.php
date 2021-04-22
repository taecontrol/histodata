<?php


namespace Taecontrol\Histodata\DataSource\Support;

use Taecontrol\Histodata\DataSource\Models\DataSource;

abstract class PollingDataSourceHandler extends DataSourceHandler
{
    abstract public function executePoll(DataSource $dataSource): void;
}
