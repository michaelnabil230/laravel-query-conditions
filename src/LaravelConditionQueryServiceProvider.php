<?php

namespace MichaelNabil230\LaravelConditionQuery;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use MichaelNabil230\LaravelConditionQuery\Commands\LaravelConditionQueryCommand;

class LaravelConditionQueryServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-condition-query')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-condition-query_table')
            ->hasCommand(LaravelConditionQueryCommand::class);
    }
}
