<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Work extends Model implements HasMedia
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

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class);
    }
}
