<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;


    protected $fillable = [
        'name',
        'email', 
        'type',
        'username',
        'email_verified_at',
        'photo_url',
        'blocked',
        'last_shift_start',
        'last_shift_end',
        'shift_active',
        'leader'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }


}


