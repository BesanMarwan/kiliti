<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use App\Rules\PasswordPolicy;
use App\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "RegisterFamilyInfo",
    title: "RegisterFamilyInfo",
    required: ["mobile", "relationship"],
    properties: [
        new OA\Property(
            property: "name",
            description: "family member name",
            type: "string",
        ),
        new OA\Property(
            property: "mobile",
            description: "family member Mobile",
            type: "string",
        ),
        new OA\Property(
            property: "relationship",
            description: "User relationship",
            type: "string",
        ),
        new OA\Property(
            property: "can_view_health_data",
            description: "can view health data",
            type: "number",
            enum: [0,1]
        ),
        new OA\Property(
            property: "can_receive_alerts	",
            description: "can receive alerts",
            type: "number",
            enum: [0,1]
        )
    ]
)]
class RegisterFamilyInfoRequest extends FormRequest
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
            'name'   => ['nullable','string'],
            'mobile' => ['required', new ValidMobile(),Rule::unique('users','mobile')],
            'relationship' => ['required', 'string'],
            'can_view_health_data' => ['nullable', 'boolean'],
            'can_receive_alerts'  => ['nullable', 'boolean'],
        ];
    }


}
