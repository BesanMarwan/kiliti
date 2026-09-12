<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
            'name' => 'required|max:255',
            'role_id' => 'required',
        ];
        $id=$this->id;
        if($id > 0){
            //update
            $rules=array_merge($rules,[
                'mobile' => ['required','numeric',Rule::unique('admins','mobile')->ignore($id)],
                'email' => ['required','max:255',Rule::unique('admins','email')->ignore($id)],

            ]);
        }else{
            //create
            $rules=array_merge($rules,[
                'mobile' => ['required','numeric',Rule::unique('admins','mobile')],
                'email' => ['required','max:255',Rule::unique('admins','email')],
                'password' => ['required','min:8'],

            ]);
        }
        return $rules;
    }
}
