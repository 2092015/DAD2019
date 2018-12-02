<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Order extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'state',
        'meal_id',
        'description',
        'item_id',
        'responsible_cook_id',
        'start',
        'end',
        'created_at',
        'updated_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }


}