<?php


namespace Taecontrol\Histodata\VirtualDataSource;

use Carbon\CarbonInterval;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\DataTransferObjects\DataPointDTO;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\DataSource\Support\PollingDataSourceHandler;
use Taecontrol\Histodata\PointValue\DataTransferObjects\NumericPointValueDTO;
use Taecontrol\Histodata\PointValue\Enums\PointValueType;
use Taecontrol\Histodata\PointValue\Models\NumericPointValue;
use Taecontrol\Histodata\VirtualDataSource\DataTransferObjects\VirtualDataPointConfigurationDTO;
use Taecontrol\Histodata\VirtualDataSource\DataTransferObjects\VirtualDataSourceConfigurationDTO;

class VirtualDataSourceHandler extends PollingDataSourceHandler
{
    protected array $numericPointValues = [];
    protected array $alphanumericPointValues = [];
    protected array $binaryPointValues = [];

    public function initialize(): void
    {
        // Implements
    }

    public function executePoll(DataSource $dataSource): void
    {
        $dataPoints = $this->getDataPoints($dataSource);
        $timestamp = now();
        $lastPoll = Cache::get("{$dataSource->id}_last_poll_at");

        $dataPoints->each(function (DataPoint $dataPoint) use ($timestamp, $lastPoll) {
            if (PointValueType::NUMERIC()->equals($dataPoint->data_type)) {
                $this->addNumericPointValue($dataPoint, $timestamp, $lastPoll);
            }
        });

        NumericPointValue::insert($this->numericPointValues);
    }

    /**
     * @throws UnknownProperties
     */
    protected function addNumericPointValue(DataPoint $dataPoint, Carbon $timestamp, Carbon|null $lastPoll): void
    {
        $value = null;

        $configurationDTO = $this->getDataPointConfiguration($dataPoint->toDTO());
        $secondsSinceCreation = CarbonInterval::make($dataPoint->created_at->diff($timestamp))->totalSeconds;
        $secondsSinceLastPoll = $lastPoll ? CarbonInterval::make($lastPoll->diff($timestamp))->totalSeconds : null;

        if ($secondsSinceLastPoll === null || $secondsSinceCreation < $secondsSinceLastPoll) {
            $value = $configurationDTO->initial_value;
        } elseif ($configurationDTO->change_type === 'random') {
            $value = $this->randomFloat($configurationDTO->min, $configurationDTO->max);
        }

        if ($value) {
            $numericPointValue = new NumericPointValueDTO(
                value: $value,
                timestamp: $timestamp,
                data_point_id: $dataPoint->id
            );

            $this->numericPointValues[] = $numericPointValue->toArray();
        }
    }

    protected function getDataPoints(DataSource $dataSource): Collection|array
    {
        return DataPoint::query()
            ->where('data_source_id', $dataSource->id)
            ->where('enabled', true)
            ->get();
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

    public function getType(): string
    {
        return 'VIRTUAL';
    }

    public function getDataSourceConfigurationDTOClass(): string
    {
        return VirtualDataSourceConfigurationDTO::class;
    }

    public function getDataPointConfigurationDTOClass(): string
    {
        return VirtualDataPointConfigurationDTO::class;
    }
}
