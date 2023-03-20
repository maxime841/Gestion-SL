<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DjParty extends Model
{
    use HasFactory;

    protected $fillable = [
        'dj_id',
        'party_id',
        ];
}
