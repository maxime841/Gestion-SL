<?php

namespace App\Models;

use App\Models\User;
use App\Models\Picture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commentaire extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'title',
        'content',

        ];


    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
     /**
     * Get the parent pictureable model (land or pictureland or house or picturehouse or other).
     */
    
    public function pictures()
    {
        return $this->morphMany(Picture::class, 'pictureable');
    } 
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
