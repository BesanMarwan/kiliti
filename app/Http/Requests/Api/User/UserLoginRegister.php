<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use App\Rules\PasswordPolicy;
use App\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "UserLoginRegister",
    title: "UserLoginRegister",
    required: ["mobile", "password"],
    properties: [
        new OA\Property(
            property: "mobile",
            description: "user mobile",
            type: "number"
        ),

        new OA\Property(
            property: "password",
            description: "user password",
            type: "string"
        )
    ]
)]
class UserLoginRegister extends FormRequest
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
            'mobile' => ['required',new ValidMobile()],
            'password' => ['required'],
        ];
    }
}
