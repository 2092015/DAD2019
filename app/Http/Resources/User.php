<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'photo_url' => '/storage/profiles/'.$this->photo_url,
            'username' => $this->username,
            'blocked' => $this->blocked,
            'last_shift_start' => $this->last_shift_start,
            'last_shift_end' => $this->last_shift_end,
            'shift_active' => $this->shift_active,
        ];
    }

}
