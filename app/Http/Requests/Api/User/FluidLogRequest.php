<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use App\Rules\PasswordPolicy;
use App\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "FluidLog",
    title: "FluidLog",
    required: [ "amount_ml"],
    properties: [
        new OA\Property(
            property: "fluid_type",
            description: "drink/fluid type ",
            type: "string"
        ),

        new OA\Property(
            property: "amount_ml",
            description: "fluid amount in ml",
            type: "number"
        )
    ]
)]
class FluidLogRequest extends FormRequest
{

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
       return  [
            'fluid_type' => ['nullable','string'],
           'amount_ml' => ['required', 'integer', 'min:50', 'max:5000', 'multiple_of:50'],
        ];
    }

    public function messages(): array
    {
        return [

            'amount_ml.required' =>
                'كمية السائل مطلوبة.',

            'amount_ml.integer' =>
                'كمية السائل يجب أن تكون رقمًا صحيحًا.',

            'amount_ml.min' =>
                'أقل كمية مسموحة هي 50 مل.',

            'amount_ml.max' =>
                'أقصى كمية مسموحة هي 5000 مل.',

            'amount_ml.multiple_of' =>
                'كمية السائل يجب أن تكون من مضاعفات 50 مل.',
        ];
    }
}
