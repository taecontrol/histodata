<?php


namespace Taecontrol\Histodata\PointValue\Actions;


use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\DataTransferObjects\DataPointDTO;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\PointValue\DataTransferObjects\AlphanumericPointValueDTO;
use Taecontrol\Histodata\PointValue\DataTransferObjects\BinaryPointValueDTO;
use Taecontrol\Histodata\PointValue\DataTransferObjects\NumericPointValueDTO;
use Taecontrol\Histodata\PointValue\Enums\PointValueType;
use Taecontrol\Histodata\PointValue\Exceptions\InvalidPointValueType;

class StorePointValue
{
    /**
     * @throws UnknownProperties
     * @throws InvalidPointValueType
     */
    public function execute(array $data): NumericPointValueDTO|AlphanumericPointValueDTO|BinaryPointValueDTO
    {
        $dataPointDTO = $this->getDataPoint($data['data_point_id']);

        if (PointValueType::NUMERIC()->equals($dataPointDTO->data_type)) {
            return $this->storeNumericPointValue($data);
        }

        if (PointValueType::ALPHANUMERIC()->equals($dataPointDTO->data_type)) {
            return $this->storeAlphanumericPointValue($data);
        }

        if (PointValueType::BINARY()->equals($dataPointDTO->data_type)) {
            return $this->storeBinaryPointValue($data);
        }

        throw new InvalidPointValueType();
    }

    /**
     * @throws UnknownProperties
     */
    protected function storeNumericPointValue(array $data): NumericPointValueDTO
    {
        $numericPointValueDTO = new NumericPointValueDTO(
            value: $data['value'],
            timestamp: $data['timestamp'],
            data_point_id: $data['data_point_id'],
        );

        return app(StoreNumericPointValue::class)
            ->execute($numericPointValueDTO);
    }

    /**
     * @throws UnknownProperties
     */
    protected function storeAlphanumericPointValue(array $data): AlphanumericPointValueDTO
    {
        $alphanumericPointValueDTO = new AlphanumericPointValueDTO(
            value: $data['value'],
            timestamp: $data['timestamp'],
            data_point_id: $data['data_point_id'],
        );

        return app(StoreAlphanumericPointValue::class)
            ->execute($alphanumericPointValueDTO);
    }

    /**
     * @throws UnknownProperties
     */
    protected function storeBinaryPointValue(array $data): BinaryPointValueDTO
    {
        $binaryPointValueDTO = new BinaryPointValueDTO(
            value: $data['value'],
            timestamp: $data['timestamp'],
            data_point_id: $data['data_point_id'],
        );

        return app(StoreBinaryPointValue::class)
            ->execute($binaryPointValueDTO);
    }

    protected function getDataPoint(string $id): DataPointDTO
    {
        $dataPoint = DataPoint::query()->findOrFail($id);

        return $dataPoint->toDTO();
    }
}