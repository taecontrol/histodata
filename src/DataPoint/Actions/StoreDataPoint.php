<?php


namespace Taecontrol\Histodata\DataPoint\Actions;

use Taecontrol\Histodata\DataPoint\DataTransferObjects\DataPointDTO;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;

class StoreDataPoint
{
    public function execute(DataPointDTO $dataPointDTO): DataPointDTO
    {
        $dataPoint = DataPoint::create([
            'id' => $dataPointDTO->id,
            'name' => $dataPointDTO->name,
            'enabled' => $dataPointDTO->enabled,
            'data_source_id' => $dataPointDTO->data_source_id,
            'data_type' => $dataPointDTO->data_type,
            'configuration' => $dataPointDTO->configuration->toArray(),
        ]);

        return $dataPoint->toDTO();
    }
}
