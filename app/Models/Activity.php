<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
