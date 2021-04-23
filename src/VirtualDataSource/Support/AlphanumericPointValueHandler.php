<?php


namespace Taecontrol\Histodata\VirtualDataSource\Support;

use Carbon\Carbon;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\PointValue\DataTransferObjects\AlphanumericPointValueDTO;

class AlphanumericPointValueHandler extends PointValueHandler
{
    public function handle(DataSource $dataSource, DataPoint $dataPoint, Carbon $timestamp): AlphanumericPointValueDTO | null
    {
        $value = null;

        $configurationDTO = $this->getDataPointConfiguration($dataPoint);
        $secondsSinceCreation = $this->getSecondsSinceCreation($dataPoint, $timestamp);
        $secondsSinceLastPoll = $this->getSecondsSinceLastPoll($dataSource, $timestamp);

        if ($secondsSinceLastPoll === null || $secondsSinceCreation < $secondsSinceLastPoll) {
            $value = (string)$configurationDTO->initial_value;
        }

        return $this->alphanumericPointValue($value, $dataPoint, $timestamp);
    }
}
