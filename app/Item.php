<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Item extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'type',
        'description',
        'photo_url',
        'price',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    public function order()
    {
        return $this->hasMany(Order::class);
    }


}