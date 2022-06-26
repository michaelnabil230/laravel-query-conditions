<?php

namespace MichaelNabil230\LaravelQueryConditions;

use Illuminate\Http\Request;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use MichaelNabil230\LaravelQueryConditions\Support\ParentQuery;
use MichaelNabil230\LaravelQueryConditions\Commands\InstallCommand;

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
