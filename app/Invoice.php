<?php
/**
 * Created by PhpStorm.
 * User: ciscomen
 * Date: 18/12/2018
 * Time: 22:05
 */

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Invoice extends Authenticatable
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


    public function meals()
    {
        return $this->belongsTo(Meal::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

}
