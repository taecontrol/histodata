<?php


namespace Taecontrol\Histodata\DataSource\Support;


abstract class PollingDataSourceHandler extends DataSourceHandler
{
    abstract public function initialize(): void;

    abstract public function executePoll(): void;
}