<?php

namespace MichaelNabil230\LaravelQueryConditions\Concerns;

use Illuminate\Database\Eloquent\Builder;
use MichaelNabil230\LaravelQueryConditions\Support\MiniQuery;
use MichaelNabil230\LaravelQueryConditions\Support\ParentQuery;

trait HasQueryCondonation
{
    public function scopeParseQBGroup(Builder $query, ParentQuery $group, string $method): void
    {
        // TODO: Remove condition it is not needed in feature
        $method = $method == 'all' ? 'where' : 'orWhere';

        $query->{$method}(function ($query) use ($group) {
            $subMethod = $group->method == 'all' ? 'where' : 'orWhere';

            foreach ($group->children as $child) {
                if ($child->isType('query-builder-group')) {
                    $query->parseQBGroup($child->toParentQuery(), $subMethod);
                } else {
                    $query->parseQBRule($child->query->miniQuery, $subMethod);
                }
            }
        });
    }

    abstract protected function scopeParseQBRule(Builder $query, MiniQuery $miniQuery, string $method): void;
}
