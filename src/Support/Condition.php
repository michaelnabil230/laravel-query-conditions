<?php

namespace MichaelNabil230\QueryConditions\Support;

class Condition
{
    public function __construct(
        public string $rule,
        public string $operator,
        public string $value,
    ) {
    }

    public static function create(
        string $rule,
        string $operator,
        string $value
    ): self {
        return new self($rule, $operator, $value);
    }

    public function __toString(): string
    {
        return $this->rule.' '.$this->operator.' '.$this->value;
    }

    public function toArray(): array
    {
        return [
            'rule' => $this->rule,
            'operator' => $this->operator,
            'value' => $this->value,
        ];
    }
}
