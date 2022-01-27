<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Update extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['language_id', 'group_id', 'sort'];

    protected $casts = [
        'enabled' => 'boolean',
        'date' => 'date'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('small')
            ->width('800');
    }


    public function articles()
    {
        return $this->morphMany(Block::class, 'article');
    }
}
