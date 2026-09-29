<?php

namespace App\Http\Requests\Api\User;

use App\Models\GeneralData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorConsultationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->patient;
    }

    public function rules(): array
    {
        $general_item  = GeneralData::where('uuid','consultation_type')->firstOrfail();
        return [
            'doctor_id'              => ['required', 'integer', 'exists:doctors,id'],
            'consultation_type'      => ['required', 'numeric',Rule::exists('general_data','id')->where('parent_id',$general_item->id) ],
            'message'                => ['required', 'string', 'min:5', 'max:5000'],
        ];
    }
}
