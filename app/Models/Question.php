<?php

namespace App\Models;

use App\Traits\HasSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory, HasSettings;
    
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function examination(): BelongsTo
    {
        return $this->belongsTo(Examination::                                                                                                   class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
