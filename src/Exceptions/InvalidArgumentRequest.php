<?php

namespace MichaelNabil230\QueryConditions\Exceptions;

use InvalidArgumentException;

final class InvalidArgumentRequest extends InvalidArgumentException
{
    public static function make(string $argument)
    {
        return new self('Invalid argument request for argument: '.$argument);
    }
}
