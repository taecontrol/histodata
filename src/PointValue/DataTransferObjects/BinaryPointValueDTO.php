<?php


namespace Taecontrol\Histodata\PointValue\DataTransferObjects;

use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class BinaryPointValueDTO extends DataTransferObject
{
    public bool $value;
    public Carbon $timestamp;
    public string $data_point_id;
}
