<?php

namespace MichaelNabil230\LaravelQueryConditions\Support;

class Query
{
    public ?Condition $condition;
    public ?string $method;
    /** @var Children[]|null */
    public ?array $children;

    public function __construct(array $query)
    {
        $this->condition = Condition::create(
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
        return $this->condition->__toString() . ' ' . $this->method . ' ' . $this->children;
    }

    public function toArray(): array
    {
        return [
            'condition' => $this->condition->toArray(),
            'method' => $this->method,
            'children' => $this->children,
        ];
    }
}
