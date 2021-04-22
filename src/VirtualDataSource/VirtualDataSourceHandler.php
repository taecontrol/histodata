<?php


namespace Taecontrol\Histodata\VirtualDataSource;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\DataSource\Support\PollingDataSourceHandler;
use Taecontrol\Histodata\PointValue\Enums\PointValueType;
use Taecontrol\Histodata\PointValue\Models\NumericPointValue;
use Taecontrol\Histodata\VirtualDataSource\DataTransferObjects\VirtualDataPointConfigurationDTO;
use Taecontrol\Histodata\VirtualDataSource\DataTransferObjects\VirtualDataSourceConfigurationDTO;
use Taecontrol\Histodata\VirtualDataSource\Support\NumericPointValueHandler;

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

        $dataPoints->each(function (DataPoint $dataPoint) use ($timestamp, $dataSource) {
            if (PointValueType::NUMERIC()->equals($dataPoint->data_type)) {
                $this->handleNumericValue($dataSource, $dataPoint, $timestamp);
            }
        });

        NumericPointValue::insert($this->numericPointValues);
    }

    protected function getDataPoints(DataSource $dataSource): Collection|array
    {
        return DataPoint::query()
            ->where('data_source_id', $dataSource->id)
            ->where('enabled', true)
            ->get();
    }

    protected function handleNumericValue(DataSource $dataSource, DataPoint $dataPoint, Carbon $timestamp): void
    {
        $value = (new NumericPointValueHandler)->handle($dataSource, $dataPoint, $timestamp);

        if ($value) {
            $this->numericPointValues[] = $value->toArray();
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
