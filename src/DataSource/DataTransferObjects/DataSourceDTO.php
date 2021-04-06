<?php


namespace Taecontrol\Histodata\DataSource\DataTransferObjects;


use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;
use Taecontrol\Histodata\DataSource\Casters\DataSourceConfigurationCaster;

class DataSourceDTO extends DataTransferObject
{
    public string $id;
    public string $name;

    #[CastWith(DataSourceConfigurationCaster::class)]
    public DataSourceConfigurationDTO $configuration;
}