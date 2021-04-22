<?php


namespace Taecontrol\Histodata\VirtualDataSource\Support;

use Carbon\Carbon;
use Exception;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\PointValue\DataTransferObjects\NumericPointValueDTO;

class NumericPointValueHandler extends PointValueHandler
{
    /**
     * @throws UnknownProperties
     */
    public function handle(DataSource $dataSource, DataPoint $dataPoint, Carbon $timestamp): NumericPointValueDTO | null
    {
        $value = null;

        $configurationDTO = $this->getDataPointConfiguration($dataPoint);
        $secondsSinceCreation = $this->getSecondsSinceCreation($dataPoint, $timestamp);
        $secondsSinceLastPoll = $this->getSecondsSinceLastPoll($dataSource, $timestamp);

        if ($secondsSinceLastPoll === null || $secondsSinceCreation < $secondsSinceLastPoll) {
            $value = (float)$configurationDTO->initial_value;
        } elseif ($configurationDTO->change_type === 'RANDOM') {
            $value = $this->randomFloat($configurationDTO->min, $configurationDTO->max);
        }

        return $this->numericPointValue($value, $dataPoint, $timestamp);
    }

    protected function randomFloat(float $min = 0, float $max = 1.0, $mul = 1000000): float
    {
        try {
            if ($min > $max) {
                return random_int($max * $mul, $min * $mul) / $mul;
            }

            return random_int($min * $mul, $max * $mul) / $mul;
        } catch (Exception) {
            return 0;
        }
    }
}
