<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use App\Rules\PasswordPolicy;
use App\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "RegisterInitial",
    title: "RegisterInitial",
    required: ["name", "mobile", "password"],
    properties: [
        new OA\Property(
            property: "name",
            description: "user name",
            type: "string"
        ),
        new OA\Property(
            property: "mobile",
            description: "user mobile",
            type: "number"
        ),
        new OA\Property(
            property: "password",
            description: "user password",
            type: "string"
        ),
    ]
)]
class RegisterInitialRequest extends FormRequest
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
            'mobile' => ['required',new ValidMobile(),Rule::unique('users','mobile')],
            'password' => ['required',new PasswordPolicy()],
            'name' => ['required','min:3', 'max:255'],
        ];

    }
}
