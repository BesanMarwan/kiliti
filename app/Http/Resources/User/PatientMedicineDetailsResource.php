<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientMedicineDetailsResource extends JsonResource
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
            'description'      => $this->medication->description,
            'important_alert'  => $this->medication->name,
            'category'         => $this->medication->category->name ?? null,
            'frequency'        => $this->frequency,
            'dosage'           => $this->dosage,
            'route'            => $this->routeObj,
            'next_dose_time'   => $this->next_dose_time->format('H:i'),
            'reminder_times'   => $this->reminder_times,
            'reminder_enabled' => $this->reminder_enabled,
            'doctor_name'      => $this->doctor->user->name,
            'status'           => $this->status,
            'start_date'       => $this->start_date,
            'end_date'         => $this->end_date,
        ];
    }
}
