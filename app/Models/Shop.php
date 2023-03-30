<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Picture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner',
        'presentation',
        'description',
        'picture',
        ];


        public function articles()
        {
        return $this->HasMany(Article::class);
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
