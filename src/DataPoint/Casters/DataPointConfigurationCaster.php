<?php


namespace Taecontrol\Histodata\DataPoint\Casters;

use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\Enums\DataPointModelType;
use Taecontrol\Histodata\VirtualDataSource\DataTransferObjects\VirtualDataPointConfigurationDTO;

class DataPointConfigurationCaster implements Caster
{
    /**
     * @throws UnknownProperties
     */
    public function cast(mixed $value): VirtualDataPointConfigurationDTO | null
    {
        if (DataPointModelType::VIRTUAL()->equals($value['model_type'])) {
            return new VirtualDataPointConfigurationDTO($value);
        }

        return null;
    }
}
