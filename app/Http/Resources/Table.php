<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\Resource;

class Table extends Resource
{
    public function toArray($request)
    {
        return [
            'table_number' => $this->table_number,
            'meals' => $this->meals,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }

}

