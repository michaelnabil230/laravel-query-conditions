<?php

namespace MichaelNabil230\QueryConditions;

use MichaelNabil230\QueryConditions\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class QueryConditionsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('query-conditions')
            ->hasCommand(InstallCommand::class);
    }
}
