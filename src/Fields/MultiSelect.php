<?php

namespace MichaelNabil230\QueryConditions\Fields;

class MultiSelect extends Field
{
    /**
     * The operators of the field.
     *
     * @var array<int, string>
     */
    public $operators = [];

    /**
     * The field's options callback.
     *
     * @var array<string|int, array<string, mixed>|string>|\Closure|callable|\Illuminate\Support\Collection|null
     */
    public $optionsCallback;

    /**
     * Set display using label for the field.
     *
     * @var bool
     */
    public $displayUsingLabel = false;

    /**
     * Set the options for the select menu.
     *
     * @param  array<string|int, array<string, mixed>|string>|\Closure|callable|\Illuminate\Support\Collection  $options
     * @return $this
     */
    public function options($options)
    {
        $this->optionsCallback = $options;

        return $this;
    }

    /**
     * Display values using their corresponding specified labels.
     *
     * @return $this
     */
    public function displayUsingLabels()
    {
        $this->displayUsingLabel = true;

        return $this;
    }

    /**
     * Serialize options for the field.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function serializeOptions()
    {
        $options = value($this->optionsCallback);

        if (is_callable($options)) {
            $options = $options();
        }

        return collect($options ?? [])->map(function ($label, $value) {
            return is_array($label) ? $label + ['value' => $value] : ['label' => $label, 'value' => $value];
        })->values()->all();
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $this->withMeta([
            'options' => $options = $this->serializeOptions(),
        ]);

        if ($this->displayUsingLabel === true) {
            $this->displayUsing(function ($value) use ($options) {
                return collect($options)
                    ->where('value', $value)
                    ->first()['label'] ?? $value;
            });
        }

        return parent::jsonSerialize();
    }
}
