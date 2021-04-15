<?php


namespace Taecontrol\Histodata\DataSource\Support;

abstract class DataSourceHandler
{
    abstract public function getType(): string;

    abstract public function getDataSourceConfigurationDTOClass(): string;

    abstract public function getDataPointConfigurationDTOClass(): string;
}
