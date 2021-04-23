<?php


namespace Taecontrol\Histodata\VirtualDataSource\Support;


use Carbon\Carbon;
use Exception;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\PointValue\DataTransferObjects\BinaryPointValueDTO;

class BinaryPointValueHandler extends PointValueHandler
{
    public function handle(DataSource $dataSource, DataPoint $dataPoint, Carbon $timestamp): BinaryPointValueDTO|null
    {
        $value = null;

        $configurationDTO = $this->getDataPointConfiguration($dataPoint);
        $secondsSinceCreation = $this->getSecondsSinceCreation($dataPoint, $timestamp);
        $secondsSinceLastPoll = $this->getSecondsSinceLastPoll($dataSource, $timestamp);

        if ($secondsSinceLastPoll === null || $secondsSinceCreation < $secondsSinceLastPoll) {
            $value = (bool)$configurationDTO->initial_value;
        } elseif ($configurationDTO->change_type === 'RANDOM') {
            $value = $this->randomBoolean();
        }

        return $this->binaryPointValue($value, $dataPoint, $timestamp);
    }

    protected function randomBoolean(): bool
    {
        try {
            return random_int(0, 1) === 1;
        } catch (Exception $_e) {
            return false;
        }
    }
}