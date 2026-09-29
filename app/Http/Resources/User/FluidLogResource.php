<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class FluidLogResource extends JsonResource
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
            'id'  => $this->id,
            'recorded_at' => $this->recorded_at,
            'amount_ml' => (integer)$this->amount_ml,
            'fluid_type' => $this->fluid_type ?? '',
        ];
    }
}
