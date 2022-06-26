<?php

namespace MichaelNabil230\LaravelQueryConditions\Exceptions;

use InvalidArgumentException;

class InvalidArgumentRequest extends InvalidArgumentException
{
    public static function make($argument)
    {
        return new static('Invalid argument request for argument: ' . $argument);
    }
}
