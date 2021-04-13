<?php


namespace Taecontrol\Histodata\DataSource\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

abstract class DataSourceConfigurationDTO extends DataTransferObject
{
    public string $model_type;
}
