<?php


namespace Taecontrol\Histodata\VirtualDataSource\DataTransferObjects;

use Taecontrol\Histodata\DataPoint\DataTransferObjects\DataPointConfigurationDTO;

class VirtualDataPointConfigurationDTO extends DataPointConfigurationDTO
{
    public string $change_type;
    public float $min;
    public float $max;
    public float $max_change;
}