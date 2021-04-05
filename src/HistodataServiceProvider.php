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
            ->hasMigrations([
                'create_numeric_point_values_table',
                'create_binary_point_values_table',
                'create_alphanumeric_point_values_table']
            )
            ->hasCommand(HistodataCommand::class);
    }
}
