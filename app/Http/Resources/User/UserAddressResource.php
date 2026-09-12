<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
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
            'id' => $this->id,
            'name'=>$this->address_name,
            'country'=>$this->country,
            'city'=>$this->city,
            'street'=>$this->street,
            'sub_street'=>$this->sub_street,
            'address_type'=>$this->address_type_text,
            'address_number'=> $this->address_number??'' ,
            'latitude'=> $this->lat??'' ,
            'longitude'=> $this->lng??'' ,
            'others' => $this->others ,
        ];
    }
}
