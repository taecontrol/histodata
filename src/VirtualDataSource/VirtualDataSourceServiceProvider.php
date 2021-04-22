<?php


namespace Taecontrol\Histodata\VirtualDataSource;

use Illuminate\Support\ServiceProvider;
use Taecontrol\Histodata\Facades\Histodata;

class VirtualDataSourceServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Histodata::registerDataSource(new VirtualDataSourceHandler());
    }
}
