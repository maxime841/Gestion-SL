<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DancerParty extends Model
{
    use HasFactory;

    protected $fillable = [
        'dancer_id',
        'party_id',
        ];
}

