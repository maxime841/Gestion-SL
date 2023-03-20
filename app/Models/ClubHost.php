<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClubHost extends Pivot
{
    
    protected $fillable = [
        'club_id',
        'host_id',
        ];

}