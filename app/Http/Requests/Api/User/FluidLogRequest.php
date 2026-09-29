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
            'amount_ml' => ['required','numeric'],
        ];
    }
}
