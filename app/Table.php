<?php
/**
 * Created by PhpStorm.
 * User: ciscomen
 * Date: 09/12/2018
 * Time: 18:51
 */

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Table extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'restaurant_tables';

    protected $fillable = [
        'table_number',
    ];

    protected $primaryKey = 'table_number';

    public function meals()
    {
        return $this->hasMany(Meal::class,'table_number');
    }
}

