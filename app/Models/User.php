<?php

namespace App\Models;

use App\Models\Role;

use App\Models\Picture;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * attribute for appends
     *
     * @return Attribute
     */
    public function thisRole(): Attribute
    {
        return new Attribute(
            get: fn () => $this->role,
        );
    }

    public function picture()
    {
        return $this->morphOne(Picture::class, 'pictureable');
    }

    /**
     * variable for relationship in json
     *
     * @var array
     */
    protected $appends = ['this_role'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'first_name',
        // 'last_name',
        // 'pseudo',
        'name',
        // 'address',
        // 'code_post',
        // 'city',
        // 'phone',
        'avatar',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
