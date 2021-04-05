<?php


namespace Taecontrol\Histodata\DataPoint\DataTransferObjects;


use Spatie\DataTransferObject\DataTransferObject;
use Taecontrol\Histodata\DataPoint\Enums\DataPointModelType;

abstract class DataPointConfigurationDTO extends DataTransferObject
{
    public DataPointModelType $model_type;
}