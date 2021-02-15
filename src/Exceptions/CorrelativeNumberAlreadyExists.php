<?php

namespace Themey99\CorrelativeNumber\Exceptions;

use InvalidArgumentException;

class CorrelativeNumberAlreadyExists extends InvalidArgumentException
{
    public static function create(string $className)
    {
        return new static("A correlative number to `{$className}` already exists.");
    }
}
