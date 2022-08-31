<?php

namespace MichaelNabil230\QueryConditions\Fields;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use JsonSerializable;
use MichaelNabil230\QueryConditions\Fields\Concerns\HasHelpText;
use MichaelNabil230\QueryConditions\Fields\Concerns\HasOperators;
use MichaelNabil230\QueryConditions\Fields\Concerns\Metable;

/**
 * @phpstan-consistent-constructor
 *
 * @method static static make(string $label, string|null $rule = null)
 */
abstract class Field implements JsonSerializable
{
    use Metable;
    use HasHelpText;
    use HasOperators;

    /**
     * The displayable label of the field.
     *
     * @var string
     */
    public $label;

    /**
     * The rule of the field.
     *
     * @var string
     */
    public $rule;

    /**
     * The default operator of the field.
     *
     * @var string
     */
    public $defaultOperator;

    /**
     * The callback to be used to resolve the field's display value.
     *
     * @var \Closure
     */
    public $displayCallback;

    /**
     * Create a new field.
     *
     * @param  string  $label
     * @param  string|null  $rule
     * @return void
     */
    public function __construct($label, $rule = null)
    {
        $this->label = $label;
        $this->rule = $rule ?? str_replace(' ', '_', Str::lower($label));
        $this->defaultOperator = $this->operators[0] ?? '=';
    }

    /**
     * Create a new field.
     *
     * @param  string  $label
     * @param  string|null  $rule
     * @return static
     */
    public static function make($label, $rule = null)
    {
        return new self($label, $rule);
    }

    /**
     * Set the placeholder text for the field if supported.
     *
     * @param  string  $text
     * @return $this
     */
    public function placeholder($text)
    {
        $this->withMeta(['extraAttributes' => ['placeholder' => $text]]);

        return $this;
    }

    /**
     * The class value that can be assigned to the field.
     *
     * @param  array  $class
     * @return $this
     */
    public function class($class)
    {
        return $this->withMeta(['class' => Arr::toCssClasses($class)]);
    }

    /**
     * Define the callback that should be used to display the field's value.
     *
     * @param  callable  $displayCallback
     * @return $this
     */
    public function displayUsing(callable $displayCallback)
    {
        $this->displayCallback = $displayCallback;

        return $this;
    }

    /**
     * Get the rule of the field.
     *
     * @return string
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_merge([
            'label' => $this->label,
            'rule' => $this->rule,
            'operators' => $this->getOperators(),
            'defaultOperator' => $this->getDefaultOperator(),
            'helpText' => $this->getHelpText(),
        ], $this->meta());
    }
}
