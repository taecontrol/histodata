<?php

namespace Taecontrol\Histodata\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Taecontrol\Histodata\DataSource\Support\DataSourceHandler;

/**
 * @see \Taecontrol\Histodata\Histodata
 *
 * @method static void registerDataSource(DataSourceHandler $dataSourceHandler)
 * @method static Collection getDataSourceTypes()
 * @method static Collection getDataSourceTypeKeys()
 * @method static bool dataSourceTypesContain(string $dataSourceType)
 * @method static string getDataSourceConfigurationDTOClass(string $dataSourceType)
 * @method static string getDataPointConfigurationDTOClass(string $dataSourceType)
 */
class Histodata extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'histodata';
    }
}
