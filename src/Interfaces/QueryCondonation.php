<?php

namespace MichaelNabil230\LaravelQueryConditions\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use MichaelNabil230\LaravelQueryConditions\Support\MiniQuery;
use MichaelNabil230\LaravelQueryConditions\Support\ParentQuery;

interface QueryCondonation
{
    public function scopeParseQBGroup(Builder $query, ParentQuery $group, string $method): void;

    public function scopeParseQBRule(Builder $query, MiniQuery $miniQuery, string $method): void;
}
