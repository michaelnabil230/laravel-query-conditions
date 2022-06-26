<?php

namespace MichaelNabil230\LaravelQueryConditions\Tests;

use MichaelNabil230\LaravelQueryConditions\LaravelQueryConditionsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelQueryConditionsServiceProvider::class,
        ];
    }
}
