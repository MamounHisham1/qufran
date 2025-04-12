<?php
namespace App\Traits;

trait HasSettings
{
    public static function findByMap(array $array): array
    {
        return array_map(fn($key) => self::find($key), $array);
    }
}