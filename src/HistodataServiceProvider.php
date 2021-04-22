<?php

namespace Taecontrol\Histodata;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Taecontrol\Histodata\Commands\PollDataCommand;
use Taecontrol\Histodata\Timescale\Timescale;

class HistodataServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('histodata')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_histodata_tables')
            ->hasCommand(PollDataCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->app->bind('histodata', function () {
            return app(Histodata::class);
        });

        $this->app->bind('timescale', function () {
            return new Timescale();
        });
    }

    public function bootingPackage(): void
    {
        $this->app->singleton(Histodata::class, function () {
            return new Histodata();
        });
    }
}
