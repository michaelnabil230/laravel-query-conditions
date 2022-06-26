<?php

namespace MichaelNabil230\LaravelQueryConditions\Fields;

class Text extends Field
{
    /**
     * The operators of the field.
     *
     * @var array
     */
    public $operators = ['equals', 'does not equal', 'contains', 'does not contain', 'is empty', 'is not empty', 'begins with', 'ends with'];
}
