<?php

namespace App\Models;

use App\Models\House;
use App\Models\Picture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Land extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner',
        'presentation',
        'description',
        'group',
        'prims',
        'remaining_prims',
        'date_buy',
        'picture_favoris',
    ];

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
        'date_buy' => 'datetime',
    ];
}
