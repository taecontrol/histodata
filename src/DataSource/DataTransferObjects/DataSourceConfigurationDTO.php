<?php


namespace Taecontrol\Histodata\DataSource\DataTransferObjects;


use Spatie\DataTransferObject\DataTransferObject;
use Taecontrol\Histodata\DataSource\Enums\DataSourceModelType;

abstract class DataSourceConfigurationDTO extends DataTransferObject {
    public DataSourceModelType $model_type;
}