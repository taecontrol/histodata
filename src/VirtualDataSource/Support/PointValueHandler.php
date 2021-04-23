<?php


namespace Taecontrol\Histodata\VirtualDataSource\Support;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\PointValue\DataTransferObjects\AlphanumericPointValueDTO;
use Taecontrol\Histodata\PointValue\DataTransferObjects\BinaryPointValueDTO;
use Taecontrol\Histodata\PointValue\DataTransferObjects\NumericPointValueDTO;
use Taecontrol\Histodata\VirtualDataSource\DataTransferObjects\VirtualDataPointConfigurationDTO;

abstract class PointValueHandler
{
    abstract public function handle(
        DataSource $dataSource,
        DataPoint $dataPoint,
        Carbon $timestamp
    ): mixed;

    protected function getDataPointConfiguration(DataPoint $dataPoint): VirtualDataPointConfigurationDTO
    {
        return $dataPoint->toDTO()->configuration;
    }

    protected function getSecondsSinceCreation(DataPoint $dataPoint, Carbon $timestamp): float | null
    {
        return CarbonInterval::make($dataPoint->created_at->diff($timestamp))->totalSeconds;
    }

    protected function getSecondsSinceLastPoll(DataSource $dataSource, Carbon $timestamp): float | null
    {
        $lastPoll = $dataSource->getLastPoll();

        return $lastPoll ? CarbonInterval::make($lastPoll->diff($timestamp))->totalSeconds : null;
    }

    protected function numericPointValue(?float $value, DataPoint $dataPoint, Carbon $timestamp): NumericPointValueDTO | null
    {
        try {
            if ($value) {
                return new NumericPointValueDTO(
                    value: $value,
                    timestamp: $timestamp,
                    data_point_id: $dataPoint->id
                );
            }
            return null;
        } catch (UnknownProperties $_e) {
            return null;
        }
    }

    protected function alphanumericPointValue(?string $value, DataPoint $dataPoint, Carbon $timestamp): AlphanumericPointValueDTO | null
    {
        try {
            if ($value) {
                return new AlphanumericPointValueDTO(
                    value: $value,
                    timestamp: $timestamp,
                    data_point_id: $dataPoint->id
                );
            }

            return null;
        } catch (UnknownProperties $_e) {
            return null;
        }
    }

    protected function binaryPointValue(?bool $value, DataPoint $dataPoint, Carbon $timestamp): BinaryPointValueDTO | null
    {
        try {
            if ($value !== null) {
                return new BinaryPointValueDTO(
                    value: $value,
                    timestamp: $timestamp,
                    data_point_id: $dataPoint->id
                );
            }

            return null;
        } catch (UnknownProperties $_e) {
            return null;
        }
    }
}
