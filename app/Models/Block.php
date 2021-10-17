<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Block extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['article_id', 'article_type', 'type', 'content', 'sort', 'enabled'];

    public function article()
    {
        return $this->morphTo();
    }
}
