<?php

namespace Themey99\CorrelativeNumber\Contracts;

interface CorrelativeNumber
{
    /**
     * Find a Record by ClassName or Create new
     * @param string|Model $modelClass
     * @param string $suffixOrPrefix
     * @return CorrelativeNumber
     */
    public static function findByClassOrCreate($modelClass, string $suffixOrPrefix = null): CorrelativeNumber;

    /**
     * Find a Record by ClassName
     * @param string|Model $modelClass
     * @return CorrelativeNumber
     * @throws \Themey99\CorrelativeNumber\Exceptions\CorrelativeNumberDoesNotExist
     */
    public static function findByClass($modelClass): CorrelativeNumber;

    /**
     * Find a Record by ClassName
     * @param string $prefixOrSuffix
     * @return CorrelativeNumber
     * @throws \Themey99\CorrelativeNumber\Exceptions\CorrelativeNumberDoesNotExist
     */
    public static function findByPrefixOrSuffix(string $prefixOrSuffix): CorrelativeNumber;

    /**
     * Reboot Sequence from Day
     * @param string|Model $modelClass
     */
    public static function rebootSequence($modelClass = null);
}