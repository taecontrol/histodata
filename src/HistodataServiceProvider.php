<?php

namespace Taecontrol\Histodata;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Taecontrol\Histodata\Commands\HistodataCommand;

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
            ->hasCommand(HistodataCommand::class);
    }
}
