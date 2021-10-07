<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Member extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
}
