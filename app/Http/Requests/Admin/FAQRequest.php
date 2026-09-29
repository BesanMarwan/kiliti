<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FAQRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->id;
        return [
            'question_ar' => ['required', 'max:50', new ValidStringArabic(), Rule::unique('faqs', 'question->ar')->ignore($id)],
            'question_en' => ['required', 'max:50', new ValidString(), Rule::unique('faqs', 'question->en')->ignore($id)],
            'answer_ar'   => ['required', 'max:50', new ValidStringArabic()],
            'answer_en'   => ['required', 'max:50', new ValidString()],
        ];

    }
}