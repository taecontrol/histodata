<?php


namespace Taecontrol\Histodata\VirtualDataSource;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\DataTransferObjects\DataPointDTO;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceDTO;
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

    public function executePoll(DataSourceDTO $dataSourceDTO): void
    {
        $dataPointDTOs = $this->getDataPointDTOs($dataSourceDTO);
        $timestamp = now();

        $dataPointDTOs->each(function (DataPointDTO $dataPointDTO) use ($timestamp) {
            if (PointValueType::NUMERIC()->equals($dataPointDTO->data_type)) {
                $this->addNumericPointValue($dataPointDTO, $timestamp);
            }
        });

        NumericPointValue::insert($this->numericPointValues);
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

    /**
     * @throws UnknownProperties
     */
    protected function addNumericPointValue(DataPointDTO $dataPointDTO, Carbon $timestamp): void
    {
        $value = null;

        $configurationDTO = $this->getDataPointConfiguration($dataPointDTO);

        if ($configurationDTO->change_type === 'random') {
            $value = $this->randomFloat($configurationDTO->min, $configurationDTO->max);
        }

        if ($value) {
            $numericPointValue = new NumericPointValueDTO(
                value: $value,
                timestamp: $timestamp,
                data_point_id: $dataPointDTO->id
            );

            $this->numericPointValues[] = $numericPointValue->toArray();
        }
    }

    protected function getDataPointDTOs(DataSourceDTO $dataSourceDTO): Collection
    {
        return DataPoint::query()
            ->where('data_source_id', $dataSourceDTO->id)
            ->where('enabled', true)
            ->get()
            ->map(fn (DataPoint $point) => $point->toDTO());
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
