<?php


namespace Taecontrol\Histodata\DataPoint\Casters;


use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\Enums\DataPointModelType;
use Taecontrol\Histodata\VirtualDataPoint\DataTransferObjects\VirtualDataPointConfigurationDTO;

class DataPointConfigurationCaster implements Caster
{

    /**
     * @param mixed $value
     * @return VirtualDataPointConfigurationDTO
     * @throws UnknownProperties
     */
    public function cast(mixed $value): VirtualDataPointConfigurationDTO
    {
        return match ($value['model_type']) {
            DataPointModelType::VIRTUAL() => new VirtualDataPointConfigurationDTO($value)
        };
    }
}