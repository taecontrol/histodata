<?php


namespace Taecontrol\Histodata\DataPoint\Casters;

use Spatie\DataTransferObject\Caster;
use Taecontrol\Histodata\DataPoint\DataTransferObjects\DataPointConfigurationDTO;
use Taecontrol\Histodata\Facades\Histodata;

class DataPointConfigurationCaster implements Caster
{
    public function cast(mixed $value): DataPointConfigurationDTO|null
    {
        $modelType = $value['model_type'];

        if (Histodata::dataSourceTypesContain($modelType)) {
            $dtoClass = Histodata::getDataPointConfigurationDTOClass($modelType);
            return new $dtoClass($value);
        }

        return null;
    }
}
