<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Work extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['language_id', 'group_id', 'sort', 'slug'];

    protected $casts = [
        'enabled' => 'boolean'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->crop('crop-center', 600, 600);

        $this->addMediaConversion('small')
            ->width('775');
    }


    public function articles()
    {
        return $this->morphMany(Block::class, 'article');
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class)->withPivot('percentage');
    }

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
