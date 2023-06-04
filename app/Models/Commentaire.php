<?php

namespace App\Models;

use App\Models\Picture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'avatar',
        'title',
        'commentaire',
        'author',
        'date_comment'
        ];

     /**
     * Get the parent pictureable model (land or pictureland or house or picturehouse or other).
     */
    public function commentaireable()
    {
        return $this->morphTo();
    }
    
    public function pictures()
    {
        return $this->morphMany(Picture::class, 'pictureable');
    }
}
