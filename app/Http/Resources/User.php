<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    public function toArray($request)
    {
        if(!starts_with($this->photo_url, '/storage/profiles/')){
            $this->photo_url = '/storage/profiles/'.$this->photo_url;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'photo_url' => $this->photo_url,
            'username' => $this->username,
            'blocked' => $this->blocked,
            'last_shift_start' => $this->last_shift_start,
            'last_shift_end' => $this->last_shift_end,
            'shift_active' => $this->shift_active,
            'email_verified_at' => $this->email_verified_at,
            'leader' => $this->leader
        ];
    }

}
