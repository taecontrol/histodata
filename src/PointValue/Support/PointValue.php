<?php

namespace Taecontrol\Histodata\PointValue\Support;

use Taecontrol\Histodata\PointValue\Enums\PointValueType;
use Taecontrol\Histodata\PointValue\Models\AlphanumericPointValue;
use Taecontrol\Histodata\PointValue\Models\BinaryPointValue;
use Taecontrol\Histodata\PointValue\Models\NumericPointValue;
use Taecontrol\Timescale\Models\TimescaleModel;

class PointValue
{
    public function getModel(PointValueType $dataPointType): TimescaleModel
    {
        return match ($dataPointType) {
            PointValueType::NUMERIC() => new NumericPointValue(),
            PointValueType::BINARY() => new BinaryPointValue(),
            PointValueType::ALPHANUMERIC() => new AlphanumericPointValue()
        };
    }
}
