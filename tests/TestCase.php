<?php

namespace Taecontrol\Histodata\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Taecontrol\Histodata\HistodataServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Taecontrol\\Histodata\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            HistodataServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        include_once __DIR__.'/../database/migrations/create_histodata_tables.php.stub';

        $histodataTables = new \CreateHistodataTables();
        $histodataTables->down();

        $histodataTables->up();
    }
}
