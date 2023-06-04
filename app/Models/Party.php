<?php

namespace App\Models;

use App\Models\Dj;
use App\Models\Club;
use App\Models\Host;
use App\Models\Dancer;
use App\Models\Picture;
use App\Models\Commentaire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function hosts()
    {
        return $this->belongsToMany(Host::class);
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
