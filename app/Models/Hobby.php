<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner',
        'presentation',
        'description',
        'picture',
        ];

        public function activities()
        {
        return $this->HasMany(Activity::class);
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
