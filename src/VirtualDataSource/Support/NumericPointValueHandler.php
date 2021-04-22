<?php


namespace Taecontrol\Histodata\VirtualDataSource\Support;


use Carbon\Carbon;
use Carbon\CarbonInterval;
use Exception;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\DataTransferObjects\DataPointDTO;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\PointValue\DataTransferObjects\NumericPointValueDTO;
use Taecontrol\Histodata\VirtualDataSource\DataTransferObjects\VirtualDataPointConfigurationDTO;

class NumericPointValueHandler
{
    /**
     * @throws UnknownProperties
     */
    public function handle(DataSource $dataSource, DataPoint $dataPoint, Carbon $timestamp): NumericPointValueDTO|null
    {
        $value = null;
        $lastPoll = $dataSource->getLastPoll();

        $configurationDTO = $this->getDataPointConfiguration($dataPoint->toDTO());
        $secondsSinceCreation = CarbonInterval::make($dataPoint->created_at->diff($timestamp))->totalSeconds;
        $secondsSinceLastPoll = $lastPoll ? CarbonInterval::make($lastPoll->diff($timestamp))->totalSeconds : null;

        if ($secondsSinceLastPoll === null || $secondsSinceCreation < $secondsSinceLastPoll) {
            $value = $configurationDTO->initial_value;
        } elseif ($configurationDTO->change_type === 'random') {
            $value = $this->randomFloat($configurationDTO->min, $configurationDTO->max);
        }

        if ($value) {
            return new NumericPointValueDTO(
                value: $value,
                timestamp: $timestamp,
                data_point_id: $dataPoint->id
            );
        }
        return null;
    }

    protected function getDataPointConfiguration(DataPointDTO $dataPointDTO): VirtualDataPointConfigurationDTO
    {
        return $dataPointDTO->configuration;
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