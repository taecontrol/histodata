<?php


namespace Taecontrol\Histodata\DataPoint\Actions;


use Exception;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;

class DeleteDataPoint
{
    /**
     * @throws Exception
     */
    public function execute(DataPoint $dataPoint): bool|null
    {
        return $dataPoint->delete();
    }
}