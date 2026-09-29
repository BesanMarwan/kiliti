<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientMedicationScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'period' => ['nullable', Rule::in(['all', 'morning', 'afternoon', 'evening']),
            ],
        ];
    }

//    public function date(): string
//    {
//        return $this->input('date', now('Asia/Gaza')->format('Y-m-d')
//    }

    public function period(): string
    {
        return $this->input('period', 'all');
    }
}
