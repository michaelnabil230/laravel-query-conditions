<?php

namespace MichaelNabil230\QueryConditions\Fields;

class Number extends Text
{
    /**
     * The operators of the field.
     *
     * @var array<int, string>
     */
    public $operators = ['=', '<>', '<', '<=', '>', '>='];

    /**
     * Create a new field.
     *
     * @param  string  $label
     * @param  string|null  $rule
     * @return void
     */
    public function __construct($label, $rule = null)
    {
        parent::__construct($label, $rule);

        $this->withMeta(['type' => 'number']);
    }

    /**
     * The minimum value that can be assigned to the field.
     *
     * @param  mixed  $min
     * @return $this
     */
    public function min($min)
    {
        return $this->withMeta(['min' => $min]);
    }

    /**
     * The maximum value that can be assigned to the field.
     *
     * @param  mixed  $max
     * @return $this
     */
    public function max($max)
    {
        return $this->withMeta(['max' => $max]);
    }

    /**
     * The step size the field will increment and decrement by.
     *
     * @param  mixed  $step
     * @return $this
     */
    public function step($step)
    {
        return $this->withMeta(['step' => $step]);
    }
}
