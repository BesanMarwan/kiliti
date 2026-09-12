<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            'id'=>$this->id,
            'action'=>$this->action->name,
            'type'=>$this->action->type,
            'amount'=>$this->amount,
            'reference' => $this->reference_id ,
            'action_time'=>$this->created_at->format('d, M Y, h:i A'),
        ];
    }
}
