<?php

namespace App\Models;

use App\Enums\AffiliatorStatus;
use App\Enums\UserGender;
use App\Enums\UserStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'role',
        'status',
        'email_verified_at',
        'birthdate'
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

    public function getUserIsAffiliation()
    {
        return ucfirst(strtolower(str_replace('_', ' ', AffiliatorStatus::getKey($this->is_affiliator))));
    }

    public function getUserStatusName()
    {
        return ucfirst(strtolower(str_replace('_', ' ', UserStatus::getKey($this->status))));
    }

    public function getUserGenderName()
    {
        return ucfirst(strtolower(str_replace('_', ' ', UserGender::getKey($this->gender))));
    }

    public function verify_code()
    {
        return $this->hasOne(VerifyCode::class);
    }

    public function hotel()
    {
        return $this->hasOne(Hotel::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Booking::class);
    }

    public function paymentRequests()
    {
        return $this->hasMany(Booking::class);
    }
}
