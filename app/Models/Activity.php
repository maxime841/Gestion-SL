<?php

namespace App\Models;

use App\Models\Hobby;
use App\Models\Picture;
use App\Models\Commentaire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner',
        'presentation',
        'description',
        'picture',
        'price',
        'tag'
        ];

        public function hobby()
        {
        return $this->belongsTo(Hobby::class);
        }
        
        public function pictures()
        {
        return $this->morphMany(Picture::class, 'pictureable');
        }

        public function commentaires()
        {
        return $this->morphMany(Commentaire::class, 'commentaireable');
        }
}
