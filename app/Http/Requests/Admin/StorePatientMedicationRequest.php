<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientMedicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [

            'patient_id' => [
                'required',
                'integer',
                'exists:patients,id',
            ],

            'medication_id' => [
                'required',
                'integer',
                Rule::exists('medications', 'id')
                    ->where('status', 'enabled'),
            ],

            'doctor_id' => [
                'nullable',
                'integer',
                'exists:doctors,id',
            ],

            'dosage' => [
                'required',
                'string',
                'max:255',
            ],

            'frequency' => [
                'required',
                Rule::in([
                    'once_daily',
                    'twice_daily',
                    'three_times_daily',
                    'four_times_daily',
                    'every_12_hours',
                    'every_8_hours',
                    'every_6_hours',
                    'as_needed',
                ]),
            ],

            'route' => [
                'required',
                Rule::in([
                    'oral',
                    'intravenous',
                    'intramuscular',
                    'subcutaneous',
                    'topical',
                    'inhalation',
                    'other',
                ]),
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'instructions' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'stopped',
                    'completed',
                ]),
            ],

            'reminder_enabled' => [
                'nullable',
                'boolean',
            ],

            'reminder_times' => [
                'nullable',
                'array',
            ],

            'reminder_times.*' => [
                'date_format:H:i',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' =>
                'يرجى اختيار المريض.',

            'patient_id.exists' =>
                'المريض المحدد غير موجود.',

            'medication_id.required' =>
                'يرجى اختيار الدواء.',

            'medication_id.exists' =>
                'الدواء المحدد غير موجود أو غير مفعل.',

            'doctor_id.exists' =>
                'الطبيب المحدد غير موجود.',

            'dosage.required' =>
                'يرجى إدخال الجرعة.',

            'frequency.required' =>
                'يرجى اختيار تكرار الدواء.',

            'frequency.in' =>
                'تكرار الدواء غير صحيح.',

            'route.required' =>
                'يرجى اختيار طريقة الاستخدام.',

            'route.in' =>
                'طريقة الاستخدام غير صحيحة.',

            'start_date.required' =>
                'يرجى تحديد تاريخ بداية الدواء.',

            'end_date.after_or_equal' =>
                'تاريخ النهاية يجب أن يكون بعد أو مساويًا لتاريخ البداية.',

            'status.required' =>
                'يرجى تحديد حالة الدواء.',

            'status.in' =>
                'حالة الدواء غير صحيحة.',

            'reminder_times.*.date_format' =>
                'وقت التذكير يجب أن يكون بصيغة HH:MM.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'reminder_enabled' =>
                $this->boolean('reminder_enabled'),
        ]);
    }

    public function validatedData(): array
    {
        $data = $this->validated();

        if (
            empty($data['reminder_enabled'])
            || empty($data['reminder_times'])
        ) {
            $data['reminder_times'] = [];
        }

        return $data;
    }
}
