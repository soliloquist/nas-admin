<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'our_teams';

    protected $casts = [
        'enabled' => 'boolean'
    ];
}
