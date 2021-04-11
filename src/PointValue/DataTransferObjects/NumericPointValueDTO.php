<?php


namespace Taecontrol\Histodata\PointValue\DataTransferObjects;


use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class NumericPointValueDTO extends DataTransferObject
{
    public float $value;
    public Carbon $timestamp;
    public string $data_point_id;
}