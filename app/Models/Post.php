<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $rules = [
        'audio' => 'required|file|mimes:mp3,wav,ogg|max:10240',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
