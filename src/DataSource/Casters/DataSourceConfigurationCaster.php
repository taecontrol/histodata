<?php


namespace Taecontrol\Histodata\DataSource\Casters;

use Spatie\DataTransferObject\Caster;
use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceConfigurationDTO;
use Taecontrol\Histodata\Facades\Histodata;

class DataSourceConfigurationCaster implements Caster
{
    public function cast(mixed $value): DataSourceConfigurationDTO|null
    {
        $modelType = $value['model_type'];

        if (Histodata::dataSourceTypesContain($modelType)) {
            $dtoClass = Histodata::getDataSourceConfigurationDTOClass($modelType);
            return new $dtoClass($value);
        }

        return null;
    }
}
