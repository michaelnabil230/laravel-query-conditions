<?php

namespace MichaelNabil230\LaravelQueryConditions\Fields;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use MichaelNabil230\LaravelQueryConditions\Fields\Field;

class Date extends Field
{
    /**
     * The operators of the field.
     *
     * @var array
     */
    public $operators = ['=', '<>', '<', '<=', '>', '>='];
    
    /**
     * The step size the field will increment and decrement by.
     *
     * @var string|int|null
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

        $this->min = $min->toDateString();

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

        $this->max = $max->toDateString();

        return $this;
    }

    /**
     * The step size the field will increment and decrement by.
     *
     * @param  string|int|\Carbon\CarbonInterval  $step
     * @return $this
     */
    public function step($step)
    {
        $this->step = $step instanceof CarbonInterval ? $step->totalDays : $step;

        return $this;
    }

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), array_filter([
            'min' => $this->min,
            'max' => $this->max,
            'step' => $this->step ?? 'any',
        ]));
    }
}
