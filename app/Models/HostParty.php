<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostParty extends Model
{
    use HasFactory;

    protected $fillable = [
        'host_id',
        'party_id',
        ];
}
