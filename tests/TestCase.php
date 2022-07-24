<?php

namespace MichaelNabil230\QueryConditions\Tests;

use MichaelNabil230\QueryConditions\QueryConditionsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            QueryConditionsServiceProvider::class,
        ];
    }
}
