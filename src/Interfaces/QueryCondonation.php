<?php

namespace MichaelNabil230\QueryConditions\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use MichaelNabil230\QueryConditions\Support\Condition;
use MichaelNabil230\QueryConditions\Support\ParentQuery;

interface QueryCondonation
{
    public function scopeParseQBGroup(Builder $query, ParentQuery $parentQuery, string $method): void;

    public function scopeParseQBRule(Builder $query, Condition $Condition, string $method): void;
}
