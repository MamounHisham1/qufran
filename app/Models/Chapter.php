<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapter extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public $connection = 'sqlite';

    public function verses(): HasMany
    {
        return $this->hasMany(Verse::class);
    }
}