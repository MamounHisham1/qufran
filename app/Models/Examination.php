<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Examination extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'start_at', 'end_at'];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}