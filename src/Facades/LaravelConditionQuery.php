<?php

namespace MichaelNabil230\LaravelConditionQuery\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MichaelNabil230\LaravelConditionQuery\LaravelConditionQuery
 */
class LaravelConditionQuery extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-condition-query';
    }
}
