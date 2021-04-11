<?php


namespace Taecontrol\Histodata\PointValue\Actions;


use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\PointValue\DataTransferObjects\NumericPointValueDTO;
use Taecontrol\Histodata\PointValue\Models\NumericPointValue;

class StoreNumericPointValue
{
    /**
     * @throws UnknownProperties
     */
    public function execute(NumericPointValueDTO $numericPointValueDTO): NumericPointValueDTO
    {
        $pointValue = NumericPointValue::create([
            'value' => $numericPointValueDTO->value,
            'timestamp' => $numericPointValueDTO->timestamp,
            'data_point_id' => $numericPointValueDTO->data_point_id
        ]);

        return new NumericPointValueDTO(
            value: $pointValue->value,
            timestamp: $pointValue->timestamp,
            data_point_id: $pointValue->data_point_id
        );
    }
}