<?php


namespace Taecontrol\Histodata\PointValue\Actions;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\PointValue\DataTransferObjects\AlphanumericPointValueDTO;
use Taecontrol\Histodata\PointValue\Models\AlphanumericPointValue;

class StoreAlphanumericPointValue
{
    /**
     * @throws UnknownProperties
     */
    public function execute(AlphanumericPointValueDTO $alphanumericPointValueDTO): AlphanumericPointValueDTO
    {
        $pointValue = AlphanumericPointValue::create([
            'value' => $alphanumericPointValueDTO->value,
            'timestamp' => $alphanumericPointValueDTO->timestamp,
            'data_point_id' => $alphanumericPointValueDTO->data_point_id,
        ]);

        return new AlphanumericPointValueDTO(
            value: $pointValue->value,
            timestamp: $pointValue->timestamp,
            data_point_id: $pointValue->data_point_id
        );
    }
}
