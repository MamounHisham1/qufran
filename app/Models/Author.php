<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function lessons(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}