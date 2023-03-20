<?php

namespace App\Models;

use App\Models\Dj;
use App\Models\Dancer;
use App\Models\Club;
use App\Models\Picture;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner',
        'presentation',
        'date_party'
        ];

        public function djs()
    {
        return $this->belongsToMany(Dj::class);
    }

    public function dancers()
    {
        return $this->belongsToMany(Dancer::class);
    }

    public function clubs()
    {
        return $this->belongsToMany(Club::class);
    }

    public function commentaires()
    {
        return $this->morphMany(Commentaire::class, 'commentaireable');
    }

    public function pictures()
    {
        return $this->morphMany(Picture::class, 'pictureable');
    }

            /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_party' => 'datetime',
        
    ];
}
