<?php

namespace MichaelNabil230\LaravelQueryConditions\Tests;

<<<<<<< HEAD
use MichaelNabil230\LaravelQueryConditions\LaravelQueryConditionsServiceProvider;
=======
use Illuminate\Database\Eloquent\Factories\Factory;
use MichaelNabil230\LaravelConditionQuery\LaravelConditionQueryServiceProvider;
>>>>>>> d80c5a7e2081ee6c2ed089fbf4ed86f4ce95b4a2
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
