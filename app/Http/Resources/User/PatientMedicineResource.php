<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientMedicineResource extends JsonResource
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
            'id'               => $this->id,
            'name'             => $this->medication->name,
            'category'         => $this->medication->category->name ?? null,
            'frequency'        => $this->frequency,
//            'reminder_times' => $this->reminder_times,
            'next_dose_time'   => $this->next_dose_time,
            'reminder_enabled' => $this->reminder_enabled,
            'doctor_name'      => $this->doctor->user->name,
            'status'           => $this->status
        ];
    }
}
