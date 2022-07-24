<?php

namespace MichaelNabil230\QueryConditions\Support;

class Query
{
    public Condition $condition;

    public string $method;

    /** @var Children[] */
    public array $children;

    public function __construct(array $query)
    {
        $this->condition = Condition::create(
            rule: data_get($query, 'rule', ''),
            operator: data_get($query, 'operator', '='),
            value: data_get($query, 'value', ''),
        );

        $this->method = data_get($query, 'method', 'where');
        $this->children = data_get($query, 'children', []);
    }

    public static function create(array $query): self
    {
        return new self($query);
    }

    public function __toString(): string
    {
        return $this->condition->__toString().' '.$this->method.' '.json_encode($this->children);
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
