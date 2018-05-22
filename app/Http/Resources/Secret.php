<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Secret extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'secret_id'=> $this->id,
            'url'=>$this->url,
            'email'=>$this->email,
            'password'=>$this->password,
            'owner'=>$this->owner
        ];
    }
}
