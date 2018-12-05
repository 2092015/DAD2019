<?php
/**
 * Created by PhpStorm.
 * User: ciscomen
 * Date: 05/12/2018
 * Time: 18:29
 */

namespace App\Http\Resources;


class Meal extends Resource
{
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'state' => $this->state,
            'table_number' => $this->meal_id,
            'responsible_waiter_id' => $this->responsible_waiter,
            'responsible_waiter' => $this->responsible_waiter->name,
            'start' => $this->start,
            'end' => $this->end,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}