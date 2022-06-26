<?php

namespace MichaelNabil230\LaravelQueryConditions\Exceptions;

use InvalidArgumentException;

class InvalidSubject extends InvalidArgumentException
{
    public static function make($subject)
    {
        return new static(
            sprintf(
                'Subject %s is invalid.',
                is_object($subject)
                    ? sprintf('class `%s`', get_class($subject))
                    : sprintf('type `%s`', gettype($subject))
            )
        );
    }
}
