<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Verse extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    public $connection = 'sqlite';

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }
}
