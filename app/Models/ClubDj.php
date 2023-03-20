<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClubDj extends Pivot
{
    
    protected $fillable = [
        'club_id',
        'dj_id',
        ];

}
