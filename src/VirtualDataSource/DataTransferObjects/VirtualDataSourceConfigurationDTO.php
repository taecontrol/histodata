<?php


namespace Taecontrol\Histodata\VirtualDataSource\DataTransferObjects;

use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceConfigurationDTO;

class VirtualDataSourceConfigurationDTO extends DataSourceConfigurationDTO
{
    public int $update_period;
    public string $update_period_type;
}
