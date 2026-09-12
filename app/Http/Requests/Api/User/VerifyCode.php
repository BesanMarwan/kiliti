<?php

namespace App\Http\Requests\Api\User;

use App\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "VerifyCode",
    title: "VerifyCode",
    required: ["code", "mobile"],
    properties: [
        new OA\Property(
            property: "mobile",
            description: "user mobile",
            type: "number"
        ),
        new OA\Property(
            property: "code",
            description: "activation code recieved on either mobile or email",
            type: "number"
        ),
    ]
)]

class VerifyCode extends FormRequest
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
        return [
            'code' => 'required',
//            'country_id' => ['required','exists:countries,id'],
            'mobile' => ['required', new ValidMobile($this->country_id)],
        ];
    }
}
