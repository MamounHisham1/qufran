<?php

namespace App\Models;

use App\Traits\HasSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory, HasSettings;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $rules = [
        'audio' => 'required|file|mimes:mp3,wav,ogg|max:10240',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Examination::class);
    }

    public function youtube()
    {
        // Regular expression to match different YouTube URL formats
        $patterns = [
            '/youtube\.com\/watch\?v=([^&]+)/',
            '/youtube\.com\/embed\/([^?]+)/',
            '/youtu\.be\/([^?]+)/',
            '/youtube\.com\/v\/([^?]+)/',
            '/youtube\.com\/.*v=([^&]+)/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->video, $matches)) {
                return $matches[1];
            }
        }

        return $this->video;
    }  
}
