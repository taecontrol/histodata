<?php


namespace Taecontrol\Histodata\DataPoint\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

abstract class DataPointConfigurationDTO extends DataTransferObject
{
    public string $model_type;
}
