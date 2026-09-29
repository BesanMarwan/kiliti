<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class PatientSymptomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->patient !== null;
    }

    public function rules(): array
    {
        return [
            'symptom_id'  => ['required','integer','exists:symptoms,id'],
            'severity'    => ['required', 'integer','between:1,5'],
//            'recorded_at' => ['required', 'date'],
            'notes'       => ['nullable', 'string','max:2000',],
        ];
    }
}
