<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    /**
     * Get the user .
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * the attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'libelle',
    ];
}
