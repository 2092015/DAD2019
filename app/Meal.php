<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Meal extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'state',
        'table_number',
        'description',
        'total_price_preview',
        'responsible_cook_id',
        'start',
        'end',
        'created_at',
        'updated_at',
    ];


    public function responsible_waiter()
    {
        return $this->belongsTo(User::class);
    }
    }
