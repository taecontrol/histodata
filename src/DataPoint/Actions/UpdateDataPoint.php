<?php


namespace Taecontrol\Histodata\DataPoint\Actions;

use Taecontrol\Histodata\DataPoint\DataTransferObjects\DataPointDTO;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;

class UpdateDataPoint
{
    public function execute(DataPoint $dataPoint, array $updates): DataPointDTO
    {
        $dataPoint->update($updates);

        return $dataPoint
            ->refresh()
            ->toDTO();
    }
}
