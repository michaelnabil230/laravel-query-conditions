<?php

namespace MichaelNabil230\LaravelQueryConditions\Fields\Concerns;

trait HasOperators
{
    /**
     * The operators of the field.
     *
     * @var array
     */
    public $operators;

    /**
     * The default operator of the field.
     *
     * @var string
     */
    public $defaultOperator;

    /**
     * Define operators for the field.
     *
     * @param  array  $operators
     * @return $this
     */
    public function operators($operators)
    {
        $this->operators = $operators;

        return $this;
    }

    /**
     * Set the default operator for the field.
     *
     * @param  string  $default
     * @return $this
     */
    public function defaultOperator($default)
    {
        $this->defaultOperator = $default;

        return $this;
    }

    /**
     * Return the operators of the field.
     *
     * @return array
     */
    public function getOperators()
    {
        return $this->operators;
    }

    /**
     * Return the default operator of the field.
     *
     * @return string
     */
    public function getDefaultOperator()
    {
        return $this->defaultOperator;
    }
}
