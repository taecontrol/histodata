<?php


namespace Taecontrol\Histodata\VirtualDataSource\DataTransferObjects;


use Taecontrol\Histodata\DataPoint\DataTransferObjects\DataPointConfigurationDTO;

class VirtualDataSourceConfigurationDTO extends DataPointConfigurationDTO
{
    public bool $polling;
}