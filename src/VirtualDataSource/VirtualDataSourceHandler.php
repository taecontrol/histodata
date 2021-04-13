<?php


namespace Taecontrol\Histodata\VirtualDataSource;


use Taecontrol\Histodata\DataSource\Support\PollingDataSourceHandler;
use Taecontrol\Histodata\VirtualDataSource\DataTransferObjects\VirtualDataPointConfigurationDTO;
use Taecontrol\Histodata\VirtualDataSource\DataTransferObjects\VirtualDataSourceConfigurationDTO;

class VirtualDataSourceHandler extends PollingDataSourceHandler
{
    public function initialize(): void
    {
        // TODO: Implement initialize() method.
    }

    public function executePoll(): void
    {
        // TODO: Implement executePoll() method.
    }

    public function getType(): string
    {
        return 'VIRTUAL';
    }

    public function getDataSourceConfigurationDTOClass(): string
    {
        return VirtualDataSourceConfigurationDTO::class;
    }

    public function getDataPointConfigurationDTOClass(): string
    {
        return VirtualDataPointConfigurationDTO::class;
    }
}