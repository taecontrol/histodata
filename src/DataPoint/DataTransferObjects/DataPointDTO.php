<?php


namespace Taecontrol\Histodata\DataPoint\DataTransferObjects;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;
use Taecontrol\Histodata\DataPoint\Casters\DataPointConfigurationCaster;
use Taecontrol\Histodata\PointValue\Enums\PointValueType;

class DataPointDTO extends DataTransferObject
{
    public ?int $id;
    public string $name;
    public bool $enabled;
    public int $data_source_id;
    public PointValueType $data_type;

    #[CastWith(DataPointConfigurationCaster::class)]
    public DataPointConfigurationDTO $configuration;
}
