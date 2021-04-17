<?php


namespace Taecontrol\Histodata\DataSource\Actions;


use Exception;
use Taecontrol\Histodata\DataSource\Models\DataSource;

class DeleteDataSource
{
    /**
     * @throws Exception
     */
    public function execute(DataSource $dataSource): bool|null
    {
        return $dataSource->delete();
    }
}