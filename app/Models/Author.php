<?php

namespace App\Models;

use App\Traits\HasSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory, HasSettings;
    
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function lessons(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
