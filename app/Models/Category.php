<?php

namespace App\Models;

use App\Traits\HasSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, HasSettings;

    protected $fillable = ['name', 'parent_category_id', 'is_published'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Examination::class);
    }
}
