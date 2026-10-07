<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MedicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->id;
        return [
            'name_ar'            => ['required','string',new ValidStringArabic(),Rule::unique('medications','name')->ignore($id)],
            'name_en'            => ['required','string',new ValidString(),Rule::unique('medications','name')->ignore($id)],
            'description_ar'     => ['required','string',new ValidStringArabic()],
            'description_en'     => ['required','string',new ValidString()],
            'important_alert_ar' => ['required','string',new ValidStringArabic()],
            'important_alert_en' => ['required','string',new ValidString()],
            'image'              => ['required']
        ];
    }
}
