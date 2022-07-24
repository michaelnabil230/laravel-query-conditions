<?php

namespace MichaelNabil230\QueryConditions\Fields;

class Text extends Field
{
    /**
     * The operators of the field.
     *
     * @var array<int, string>
     */
    public $operators = ['equals', 'does not equal', 'contains', 'does not contain', 'is empty', 'is not empty', 'begins with', 'ends with'];
}
