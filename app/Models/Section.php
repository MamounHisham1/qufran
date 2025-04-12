<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'image', 'content', 'blog_id'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
