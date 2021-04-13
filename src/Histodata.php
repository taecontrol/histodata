<?php

namespace Taecontrol\Histodata;

use Illuminate\Support\Collection;
use Taecontrol\Histodata\DataSource\Support\DataSourceHandler;

class Histodata
{
    protected Collection $dataSourceTypes;

    public function __construct()
    {
        $this->dataSourceTypes = collect();
    }

    public function registerDataSource(DataSourceHandler $dataSourceHandler): void
    {
        $this->dataSourceTypes[$dataSourceHandler->getType()] = collect([
            'handler' => get_class($dataSourceHandler),
            'dataSourceConfigurationDTO' => $dataSourceHandler->getDataSourceConfigurationDTOClass(),
            'dataPointConfigurationDTO' => $dataSourceHandler->getDataPointConfigurationDTOClass(),
        ]);
    }

    public function getDataSourceTypes(): Collection
    {
        return $this->dataSourceTypes;
    }

    public function getDataSourceTypeKeys(): Collection
    {
        return $this->getDataSourceTypes()->keys();
    }

    public function dataSourceTypesContain(string $dataSourceType): bool
    {
        return $this->getDataSourceTypeKeys()->contains($dataSourceType);
    }

    public function getDataSourceConfigurationDTOClass(string $dataSourceType): string
    {
        return $this->getDataSourceTypes()
            ->get($dataSourceType)
            ->get('dataSourceConfigurationDTO');
    }

    public function getDataPointConfigurationDTOClass(string $dataSourceType): string
    {
        return $this->getDataSourceTypes()
            ->get($dataSourceType)
            ->get('dataPointConfigurationDTO');
    }
}
