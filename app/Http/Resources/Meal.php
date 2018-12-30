<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\Resource;


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
            'total_price_preview' => $this->total_price_preview,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }

}