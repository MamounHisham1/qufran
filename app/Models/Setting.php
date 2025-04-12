<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'page'];
    public function casts(): array
    {
        return [
            'value' => 'json',
        ];
    }

    public static function set(string $page, string $key, array $value)
    {
        Setting::updateOrCreate(
            ['page' => $page, 'key' => $key],
            ['value' => $value,]
        );
    }
}
