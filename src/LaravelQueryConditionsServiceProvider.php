<?php

namespace MichaelNabil230\LaravelQueryConditions;

use Illuminate\Http\Request;
use MichaelNabil230\LaravelQueryConditions\Commands\InstallCommand;
use MichaelNabil230\LaravelQueryConditions\Support\ParentQuery;
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

    public function bootingPackage()
    {
        Request::macro('queryConditions', function ($key = 'query') {
            $query = request()->input($key);

            $root = ParentQuery::create($query['logicalOperator'], $query['children']);

            return $root;
        });
    }
}
