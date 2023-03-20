<?php

namespace App\Models;

use App\Models\Club;
use App\Models\Party;
use App\Models\Picture;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dj extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'style',
        'presentation',
        'date_entrance'
        ];

        public function clubs()
    {
        return $this->belongsToMany(Club::class);
    }

    public function parties()
    {
        return $this->belongsToMany(Party::class);
    }

    public function pictures()
        {
        return $this->morphMany(Picture::class, 'pictureable');
        }

    public function commentaires()
        {
        return $this->morphMany(Commentaire::class, 'commentaireable');
        }

        /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_entrance' => 'datetime',
        
    ];
}

        

