<?php


namespace Taecontrol\Histodata\PointValue\DataTransferObjects;


use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class AlphanumericPointValueDTO extends DataTransferObject
{
    public string $value;
    public Carbon $timestamp;
    public string $data_point_id;
}