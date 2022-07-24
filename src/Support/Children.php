<?php

namespace MichaelNabil230\QueryConditions\Support;

class Children
{
    public function __construct(
        public string $type,
        public Query $query,
    ) {
    }

    public static function create(string $type, Query $query): self
    {
        return new self($type, $query);
    }

    public function toParentQuery(): ParentQuery
    {
        return ParentQuery::create($this->query->method, $this->query->children);
    }

    public function isType(string $type): bool
    {
        return $this->type === $type;
    }
}
