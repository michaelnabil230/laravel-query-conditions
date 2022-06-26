<?php

namespace MichaelNabil230\LaravelQueryConditions;

use MichaelNabil230\LaravelQueryConditions\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelQueryConditionsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-query-conditions')
            ->hasCommand(InstallCommand::class);
    }
}
