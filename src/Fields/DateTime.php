<?php

namespace MichaelNabil230\LaravelQueryConditions\Fields;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use MichaelNabil230\LaravelQueryConditions\Fields\Field;

class DateTime extends Field
{
    /**
     * The operators of the field.
     *
     * @var array
     */
    public $operators = ['=', '<>', '<', '<=', '>', '>='];
    
    /**
     * The minimum value that can be assigned to the field.
     *
     * @var string|null
     */
    public $min;

    /**
     * The maximum value that can be assigned to the field.
     *
     * @var string|null
     */
    public $max;

    /**
     * The step size the field will increment and decrement by.
     *
     * @var int|null
     */
    public $step;

    /**
     * The minimum value that can be assigned to the field.
     *
     * @param  \Carbon\CarbonInterface|string  $min
     * @return $this
     */
    public function min($min)
    {
        if (is_string($min)) {
            $min = Carbon::parse($min);
        }

        $this->min = $min->toDateTimeLocalString();

        return $this;
    }

    /**
     * The maximum value that can be assigned to the field.
     *
     * @param  \Carbon\CarbonInterface|string  $max
     * @return $this
     */
    public function max($max)
    {
        if (is_string($max)) {
            $max = Carbon::parse($max);
        }

        $this->max = $max->toDateTimeLocalString();

        return $this;
    }

    /**
     * The step size the field will increment and decrement by.
     *
     * @param  int|\Carbon\CarbonInterval  $step
     * @return $this
     */
    public function step($step)
    {
        $this->step = $step instanceof CarbonInterval ? $step->totalSeconds : $step;

        return $this;
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_merge(array_filter([
            'min' => $this->min,
            'max' => $this->max,
            'step' => $this->step ?? 1,
        ]), parent::jsonSerialize());
    }
}
