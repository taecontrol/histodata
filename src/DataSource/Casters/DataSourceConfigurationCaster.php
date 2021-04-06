<?php


namespace Taecontrol\Histodata\DataSource\Casters;

use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataSource\Enums\DataSourceModelType;
use Taecontrol\Histodata\VirtualDataSource\DataTransferObjects\VirtualDataSourceConfigurationDTO;

class DataSourceConfigurationCaster implements Caster
{
    /**
     * @param mixed $value
     * @return VirtualDataSourceConfigurationDTO
     * @throws UnknownProperties
     */
    public function cast(mixed $value): VirtualDataSourceConfigurationDTO
    {
        return match ($value['model_type']) {
            DataSourceModelType::VIRTUAL() => new VirtualDataSourceConfigurationDTO($value)
        };
    }
}
