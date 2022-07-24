<?php

namespace MichaelNabil230\QueryConditions;

use ArrayAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\ForwardsCalls;
use InvalidArgumentException;
use MichaelNabil230\QueryConditions\Exceptions\InvalidArgumentRequest;
use MichaelNabil230\QueryConditions\Exceptions\InvalidSubject;
use MichaelNabil230\QueryConditions\Interfaces\QueryCondonation;
use MichaelNabil230\QueryConditions\Support\ParentQuery;

/**
 * @mixin Builder
 */
final class QueryConditions implements ArrayAccess
{
    use ForwardsCalls;

    protected array $conditions;

    protected Builder $subject;

    protected ParentQuery $subQuery;

    /**
     * @param  Builder|string  $subject
     * @param  array  $conditions
     * @return void
     */
    public function __construct($subject, $conditions)
    {
        $this->initializeSubject($subject)
            ->formatFromRequest($conditions)
            ->initializeParseQBGroup();
    }

    /**
     * @param  Builder|string  $subject
     * @param  array  $conditions
     * @return static
     */
    public static function for($subject, $conditions): static
    {
        if (is_subclass_of($subject, Model::class)) {
            $subject = $subject::query();
        }

        return new static($subject, $conditions);
    }

    protected function initializeSubject(Builder $subject): static
    {
        throw_unless(
            $subject instanceof Builder,
            InvalidSubject::make($subject)
        );

        $this->subject = $subject;

        return $this;
    }

    protected function formatFromRequest(array $conditions): static
    {
        $this->handlerConditionsException($conditions);

        $this->subQuery = ParentQuery::create(
            method: data_get($conditions, 'logicalOperator', 'all'),
            children: data_get($conditions, 'children')
        );

        return $this;
    }

    private function handlerConditionsException(array $conditions)
    {
        if (! is_array($conditions)) {
            throw new InvalidArgumentException('Invalid argument request for argument: conditions');
        }

        if (count($conditions) == 0) {
            throw new InvalidArgumentException('The conditions array is empty');
        }

        if (! array_key_exists('logicalOperator', $conditions)) {
            throw InvalidArgumentRequest::make('logicalOperator');
        }

        if (! array_key_exists('children', $conditions)) {
            throw InvalidArgumentRequest::make('children');
        }
    }

    protected function initializeParseQBGroup(): static
    {
        if ($this->subject instanceof QueryCondonation) {
            $this->subject->parseQBGroup($this->subject, $this->subQuery, $this->subQuery->method);
        }

        return $this;
    }

    public function __call($name, $arguments)
    {
        $result = $this->forwardCallTo($this->subject, $name, $arguments);

        /*
         * If the forwarded method call is part of a chain we can return $this
         * instead of the actual $result to keep the chain going.
         */
        if ($result === $this->subject) {
            return $this;
        }

        return $result;
    }

    public function clone()
    {
        return clone $this;
    }

    public function __clone()
    {
        $this->subject = clone $this->subject;
    }

    public function __get($name)
    {
        return $this->subject->{$name};
    }

    public function __set($name, $value)
    {
        $this->subject->{$name} = $value;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->subject[$offset]);
    }

    public function offsetGet($offset): bool
    {
        return $this->subject[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->subject[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->subject[$offset]);
    }
}
