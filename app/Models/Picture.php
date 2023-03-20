<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'picture_url',
        'favori',
        'pictureable_id',
        'pictureable_type',

    ];

    /**
     * Get the parent pictureable model (land or pictureland or house or picturehouse or other).
     */
    public function pictureable()
    {
        return $this->morphTo();
    }
}
