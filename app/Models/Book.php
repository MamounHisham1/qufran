<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public $connection = 'sqlite';
}
