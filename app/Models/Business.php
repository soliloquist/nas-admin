<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Business extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['language_id', 'group_id'];

    protected $casts = [
      'enabled' => 'boolean'
    ];


    public function articles()
    {
        return $this->morphMany(Block::class, 'article');
    }
}
