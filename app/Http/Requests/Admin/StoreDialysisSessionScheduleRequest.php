<?php

namespace App\Http\Requests\Admin;

use App\Models\DialysisSession;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Validator;

class StoreDialysisSessionScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => [
                'required',
                'integer',
                'exists:patients,id',
            ],

            'center_id' => [
                'nullable',
                'integer',
                'exists:dialysis_centers,id',
            ],

            'doctor_id' => [
                'nullable',
                'integer',
                'exists:doctors,id',
            ],


            'days' => [
                'required',
                'array',
                'min:1',
            ],

            'days.*' => [
                'required',
                'in:saturday,sunday,monday,tuesday,wednesday,thursday,friday',
            ],

            'time' => [
                'required',
                'date_format:H:i',
            ],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {

                if (
                    $this->filled('days') &&
                    $this->filled('sessions_per_week')
                ) {
                    $days = array_unique($this->input('days', []));

                    if (count($days) !== (int) $this->sessions_per_week) {
                        $validator->errors()->add(
                            'days',
                            'عدد أيام الجلسات يجب أن يساوي عدد الجلسات في الأسبوع.'
                        );
                    }
                }
            },
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'يرجى اختيار المريض.',
            'patient_id.exists' => 'المريض المحدد غير موجود.',

            'center_id.required' => 'يرجى اختيار مركز الغسيل.',
            'center_id.exists' => 'مركز الغسيل المحدد غير موجود.',

            'doctor_id.exists' => 'الطبيب المحدد غير موجود.',

            'session_type.required' => 'يرجى اختيار نوع الجلسة.',
            'session_type.in' => 'نوع الجلسة غير صحيح.',

            'start_date.required' => 'يرجى تحديد تاريخ بداية الجدول.',
            'start_date.date' => 'تاريخ البداية غير صحيح.',

            'end_date.date' => 'تاريخ نهاية الجدول غير صحيح.',
            'end_date.after_or_equal' =>
                'تاريخ النهاية يجب أن يكون بعد أو يساوي تاريخ البداية.',

            'sessions_per_week.required' =>
                'يرجى تحديد عدد الجلسات الأسبوعية.',

            'sessions_per_week.min' =>
                'يجب أن تكون هناك جلسة واحدة على الأقل أسبوعيًا.',

            'sessions_per_week.max' =>
                'لا يمكن أن يتجاوز عدد الجلسات 7 جلسات أسبوعيًا.',

            'days.required' =>
                'يرجى اختيار أيام الجلسات.',

            'days.min' =>
                'يرجى اختيار يوم واحد على الأقل.',

            'days.*.in' =>
                'أحد أيام الجلسات المحددة غير صحيح.',

            'time.required' =>
                'يرجى تحديد وقت الجلسة.',

            'time.date_format' =>
                'وقت الجلسة يجب أن يكون بالصيغة HH:MM.',
        ];
    }
}

