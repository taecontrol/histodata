<?php


namespace Taecontrol\Histodata\DataPoint\Actions;


use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\DataTransferObjects\DataPointDTO;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;

class StoreDataPoint
{
    /**
     * @throws UnknownProperties
     */
    public function execute(DataPointDTO $dataPointDTO): DataPointDTO
    {
        $dataPoint = DataPoint::create([
            'id' => $dataPointDTO->id,
            'name' => $dataPointDTO->name,
            'data_source_id' => $dataPointDTO->data_source_id,
            'data_type' => $dataPointDTO->data_type,
            'configuration' => $dataPointDTO->configuration->toArray()
        ]);

        return new DataPointDTO(
            id: $dataPoint->id,
            name: $dataPoint->name,
            data_source_id: $dataPoint->data_source_id,
            data_type: $dataPoint->data_type,
            configuration: $dataPoint->configuration
        );
    }
}