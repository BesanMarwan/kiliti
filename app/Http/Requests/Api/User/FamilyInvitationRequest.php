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
    schema: "CreateFamilyInvitation",
    title: "CreateFamilyInvitation",
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
            enum: [
                "father",
                "mother",
                "brother",
                "sister",
                "son",
                "daughter",
                "husband",
                "wife",
                "other"
            ],
            example: "sister"
        ),
        new OA\Property(
            property: "permissions",
            description: "Permissions granted to the family member",
            type: "array",
            enum: [
                "view_medications",
                "view_dialysis_sessions",
                "view_fluid_data",
                "view_symptoms",
                "view_labs",
                "view_measurements",
                "receive_alerts"
            ],
            items: new OA\Items(type: "string", example: "view_medications")
        ),
    ]
)]

class FamilyInvitationRequest extends FormRequest
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
            'relationship' => ['required', 'string', Rule::enum(FamilyRelationship::class),],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:family_permission_types,name'],
        ];

    }


}
