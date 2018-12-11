<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Order extends Resource
{
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'state' => $this->state,
            'meal_id' => $this->meal_id,
            'item_id' => $this->item_id,
            'item' => $this->item->name,
            'responsible_cook_id' => $this->responsible_cook_id,
            'responsible_cook' => $this->responsible_cook->name,
            'start' => $this->start,
            'end' => $this->end,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
