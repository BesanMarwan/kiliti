<?php

namespace App\Http\Requests\Api\User;

use App\Enums\FamilyRelationship;
use App\Models\User;
use App\Rules\PasswordPolicy;
use App\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;


#[OA\Schema(
    schema: "FamilyMemberRegister",
    title: "FamilyMemberRegister",
    required: ["name", "mobile", "password"],
    properties: [
        new OA\Property(
            property: "name",
            description: "family member name",
            type: "string",
            example: "Besan Marwan"
        ),
        new OA\Property(
            property: "mobile",
            description: "family member Mobile",
            type: "number",
            example: "0597501686"
        ),
        new OA\Property(
            property: "password",
            description: "Family Member Password",
            format: "password",
            type: "string",
            example: "password@123"
        ),
    ]
)]

class FamilyMemberRegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', new ValidMobile(),Rule::unique('users','mobile')],
            'password' => ['required', new PasswordPolicy()],
        ];

    }


}
