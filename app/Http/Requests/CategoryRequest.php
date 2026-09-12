<?php

namespace App\Http\Requests;

use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
        $rules=[
            'name_ar' => ['required','max:50',new ValidStringArabic()],
            'name_en' => ['required','max:50',new ValidString()],
        ];
        $id=$this->id;
        if($id > 0){
            //update
            $rules=array_merge($rules,[
                'image' => 'nullable',

            ]);
        }else{
            //create
            $rules=array_merge($rules,[
                'image' => 'required',
            ]);
        }
        return $rules;
    }
}
