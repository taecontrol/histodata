<?php


namespace Taecontrol\Histodata\PointValue\DataTransferObjects;


use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

abstract class PointValueDTO extends DataTransferObject
{
    public Carbon $timestamp;
    public string $data_point_id;
}