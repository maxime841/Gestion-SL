<?php

namespace App\Models;

use App\Models\Shop;
use App\Models\Picture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
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

        public function shop()
        {
        return $this->belongsTo(Shop::class);
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
