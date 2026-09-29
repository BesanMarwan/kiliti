<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DialysisSessionIssueRequest extends FormRequest
{
    public function authorize(): bool
    {
        $patient = $this->user()?->patient;

        if (!$patient) {
            return false;
        }

        $session = $this->route('dialysisSession');

        return $session && $session->patient_id === $patient->id;
    }

    public function rules(): array
    {
        return [
            'issue_type'  => ['required', 'string', Rule::exists('general_data','id')->where('uuid','dialysis_session_issue')],
            'severity'    => ['required', 'string', 'in:mild,moderate,severe'],
            'description' => ['nullable', 'string', 'max:2000'],
            'reported_at' => ['nullable', 'date'],
        ];
    }
}
