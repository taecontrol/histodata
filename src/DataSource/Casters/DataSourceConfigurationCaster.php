<?php


namespace Taecontrol\Histodata\DataSource\Casters;

use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataSource\Enums\DataSourceModelType;
use Taecontrol\Histodata\VirtualDataSource\DataTransferObjects\VirtualDataSourceConfigurationDTO;

class DataSourceConfigurationCaster implements Caster
{
    /**
     * @throws UnknownProperties
     */
    public function cast(mixed $value): VirtualDataSourceConfigurationDTO | null
    {
        if (DataSourceModelType::VIRTUAL()->equals($value['model_type'])) {
            return new VirtualDataSourceConfigurationDTO($value);
        }

        return null;
    }
}
