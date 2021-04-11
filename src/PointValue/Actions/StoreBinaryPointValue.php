<?php


namespace Taecontrol\Histodata\PointValue\Actions;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\PointValue\DataTransferObjects\BinaryPointValueDTO;
use Taecontrol\Histodata\PointValue\Models\BinaryPointValue;

class StoreBinaryPointValue
{
    /**
     * @throws UnknownProperties
     */
    public function execute(BinaryPointValueDTO $binaryPointValueDTO): BinaryPointValueDTO
    {
        $pointValue = BinaryPointValue::create([
            'value' => $binaryPointValueDTO->value,
            'timestamp' => $binaryPointValueDTO->timestamp,
            'data_point_id' => $binaryPointValueDTO->data_point_id,
        ]);

        return new BinaryPointValueDTO(
            value: $pointValue->value,
            timestamp: $pointValue->timestamp,
            data_point_id: $pointValue->data_point_id
        );
    }
}
