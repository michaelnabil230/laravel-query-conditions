<?php

namespace MichaelNabil230\QueryConditions\Concerns;

use Illuminate\Database\Eloquent\Builder;
use MichaelNabil230\QueryConditions\Support\Condition;
use MichaelNabil230\QueryConditions\Support\ParentQuery;

trait HasQueryCondonation
{
    public function scopeParseQBGroup(Builder $query, ParentQuery $parentQuery, string $method): void
    {
        // TODO: Remove condition it is not needed in feature
        $method = $method == 'all' ? 'where' : 'orWhere';

        $query->{$method}(function ($query) use ($parentQuery) {
            $subMethod = $parentQuery->method == 'all' ? 'where' : 'orWhere';

            foreach ($parentQuery->children as $child) {
                if ($child->isType('query-builder-group')) {
                    $query->parseQBGroup($child->toParentQuery(), $subMethod);
                } else {
                    $query->parseQBRule($child->query->condition, $subMethod);
                }
            }
        });
    }

    abstract protected function scopeParseQBRule(Builder $query, Condition $condition, string $method): void;
}
