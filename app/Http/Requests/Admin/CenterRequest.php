<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CenterRequest extends FormRequest
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
        $id=$this->id;
        return [
            'name'             => ['required','string',Rule::unique('dialysis_centers','name')->ignore($id)],
            'phone'            => ['required','numeric',new ValidMobile(),Rule::unique('dialysis_centers','phone')->ignore($id)],
            'governorate'      => ['required','string'],
            'city'             => ['required','string'],
            'address'          => ['required','string'],
            'total_machines'   => ['required','numeric'],
            'working_machines' => ['required','numeric','max:'.$this->total_machines],
            'status'           => ['required','string',Rule::in(['enabled','disabled','temporarily_closed'])]
        ];
    }
}
