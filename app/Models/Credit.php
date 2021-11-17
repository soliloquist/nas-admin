<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = ['id', 'work_id', 'title', 'people'];
    protected $casts = [
        'people' => 'json'
    ];
}
