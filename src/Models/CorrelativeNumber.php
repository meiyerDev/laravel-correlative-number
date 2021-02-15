<?php

namespace Themey99\CorrelativeNumber\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Themey99\CorrelativeNumber\Contracts\CorrelativeNumber as ContractsCorrelativeNumber;
use Themey99\CorrelativeNumber\Exceptions\CorrelativeNumberDoesNotExist;

class CorrelativeNumber extends Model implements ContractsCorrelativeNumber
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_owner',
        'value',
        'suffix_or_prefix',
        'type'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'int',
        'type' => 'int'
    ];

    /**
     * Find a Record by ClassName or Create new
     * @param string|Model $modelClass
     * @param string $suffixOrPrefix
     * @return CorrelativeNumber
     */
    public static function findByClassOrCreate($modelClass, string $suffixOrPrefix = null, int $type = 1): ContractsCorrelativeNumber
    {
        $modelClassName = static::getClassName($modelClass);
        $correlativeNumber = static::query()->where('model_owner', $modelClassName)->first();

        if (!$correlativeNumber) {
            $correlativeNumber = static::query()->create([
                'model_owner' => $modelClassName,
                'suffix_or_prefix' => $suffixOrPrefix,
                'type' => (int) $type
            ]);
        }

        return $correlativeNumber;
    }

    /**
     * Find a Record by ClassName
     * @param string|Model $modelClass
     * @return CorrelativeNumber
     * @throws \Themey99\CorrelativeNumber\Exceptions\CorrelativeNumberDoesNotExist
     */
    public static function findByClass($modelClass): ContractsCorrelativeNumber
    {
        $modelClassName = static::getClassName($modelClass);
        $correlativeNumber = static::query()->where('model_owner', $modelClassName)->first();

        if (! $correlativeNumber) {
            throw CorrelativeNumberDoesNotExist::create($modelClassName);
        }

        return $correlativeNumber;
    }

    /**
     * Find a Record by ClassName
     * @param string $prefixOrSuffix
     * @return CorrelativeNumber
     * @throws \Themey99\CorrelativeNumber\Exceptions\CorrelativeNumberDoesNotExist
     */
    public static function findByPrefixOrSuffix(string $prefixOrSuffix): ContractsCorrelativeNumber
    {
        $correlativeNumber = static::query()->where('suffix_or_prefix', $prefixOrSuffix)->first();
        
        if (! $correlativeNumber) {
            throw CorrelativeNumberDoesNotExist::withPrefixOrSuffix($prefixOrSuffix);
        }
        
        return $correlativeNumber;
    }

    /**
     * Reboot Sequence from Day
     * @param string|Model|null $modelClass
     */
    public static function rebootSequence($modelClass = null)
    {
        if (empty($modelClass)) {
            static::where('value', '!=', 0)->update([
                'value' => 0
            ]);
        } else {
            $modelClassName = static::getClassName($modelClass);
            static::where('model_owner', $modelClassName)->update([
                'value' => 0
            ]);
        }
    }

    /**
     * Transform Model instance in string morphClass
     * 
     */
    protected static function getClassName($modelClass): string
    {
        if ($modelClass instanceof Model) {
            return $modelClass->getMorphClass();
        }

        return app()->make($modelClass)->getMorphClass();
    }
}
