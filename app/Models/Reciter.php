<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reciter extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    public $connection = 'sqlite';

    public function chapters(): BelongsToMany
    {
        return $this->belongsToMany(Chapter::class)->withPivot('url');
    }
}
