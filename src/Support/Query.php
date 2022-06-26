<?php

namespace MichaelNabil230\LaravelQueryConditions\Support;

class Query
{
    public ?MiniQuery $miniQuery;
    public ?string $method;
    /** @var Children[]|null */
    public ?array $children;

    public function __construct(array $query)
    {
        $this->miniQuery = MiniQuery::create(
            rule: $query['rule'] ?? '',
            operator: $query['operator'] ?? '=',
            value: $query['value'] ?? '',
        );
        $this->method = $query['method'] ?? 'where';
        $this->children = $query['children'] ?? [];
    }

    public static function create(array $query): self
    {
        return new self($query);
    }

    public function __toString(): string
    {
        return $this->miniQuery->__toString() . ' ' . $this->method . ' ' . $this->children;
    }

    public function toArray(): array
    {
        return [
            'miniQuery' => $this->miniQuery->toArray(),
            'method' => $this->method,
            'children' => $this->children,
        ];
    }
}
