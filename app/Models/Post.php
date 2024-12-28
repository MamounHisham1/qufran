<?php

namespace App\Models;

use App\Traits\HasSettings;
use Carbon\Carbon;
use App\PostTypes;
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

    public static function booted()
    {
        static::creating(function ($post) {
            if ($post->type === PostTypes::Fatwa) {
                $post->fatwa_number = Post::where('type', PostTypes::Fatwa)->latest('created_at')->pluck('fatwa_number')->first() + 1;
            }
        });
    }

    // public function casts(): array
    // {
    //     return [
    //         'type' => PostTypes::class,
    //     ];
    // }

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
    
    public function getAudio()
    {
        preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $this->audio_url, $matches);

        // Check if a valid File ID was found
        if (isset($matches[1])) {
            $fileId = $matches[1];
            // Return the preview URL
            return "https://drive.google.com/file/d/{$fileId}/preview";
        }

        return null; // Return null if File ID could not be extracted
    }
}
