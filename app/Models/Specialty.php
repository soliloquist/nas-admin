<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    public function works()
    {
        return $this->belongsToMany(Work::class)->withPivot('percentage');
    }
}
