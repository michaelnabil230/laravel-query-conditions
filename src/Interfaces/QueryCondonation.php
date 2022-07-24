<?php

namespace MichaelNabil230\QueryConditions\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use MichaelNabil230\QueryConditions\Support\Condition;
use MichaelNabil230\QueryConditions\Support\ParentQuery;

interface QueryCondonation
{
    public function parseQBGroup(Builder $query, ParentQuery $group, string $method): void;

    public function parseQBRule(Builder $query, Condition $Condition, string $method): void;
}
