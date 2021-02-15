<?php

namespace Themey99\CorrelativeNumber\Exceptions;

use InvalidArgumentException;

class CorrelativeNumberDoesNotExist extends InvalidArgumentException
{
    public static function create(string $className)
    {
        return new static("There is no correlative number to `{$className}`.");
    }

    public static function withPrefixOrSuffix(int $prefixOrSuffixName)
    {
        return new static("There is no [correlative number] with prefix or suffix `{$prefixOrSuffixName}`.");
    }
}
