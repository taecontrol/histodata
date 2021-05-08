<?php


namespace Taecontrol\Histodata\DataSource\DataTransferObjects;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;
use Taecontrol\Histodata\DataSource\Casters\DataSourceConfigurationCaster;

class DataSourceDTO extends DataTransferObject
{
    public ?int $id;
    public string $name;
    public bool $enabled;
    public bool $polling;

    #[CastWith(DataSourceConfigurationCaster::class)]
    public DataSourceConfigurationDTO $configuration;
}
