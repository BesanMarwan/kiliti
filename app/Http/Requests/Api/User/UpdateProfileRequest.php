<?php

namespace App\Http\Requests\Api\User;

use App\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "UpdateProfileRequest",
    title: "UpdateProfileRequest",
    required: ["name", "mobile"],
    properties: [
        new OA\Property(
            property: "name",
            description: "name",
            type: "string"
        ),
        new OA\Property(
            property: "mobile",
            description: "user mobile",
            type: "string"
        ),
        new OA\Property(
            property: "avatar",
            description: "profile image",
            type: "string",
            format: "binary"
        ),

        new OA\Property(
            property: "birth_date",
            description: "User birth date",
            type: "string",
            format: "date"
        ),
        new OA\Property(
            property: "gender",
            description: "User gender",
            type: "string",
            enum: ["male", "female"]
        ),
        new OA\Property(
            property: "blood_type",
            description: "User blood type",
            type: "string",
            enum: ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"]
        ),

    ]
)]
class UpdateProfileRequest extends FormRequest
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
            'name'       => ['required', 'min:3', 'max:255'],
            'mobile'     => ['required', Rule::unique('users','mobile')->ignore(auth()->id()), new ValidMobile()],
            'avatar'     => ['nullable', 'image'],
            'birth_date' => ['required', 'date','before:today'],
            'gender'     => ['required', Rule::in(["male","female"])],
            'blood_type' => ['required', Rule::in(["A+","A-","B+","B-","AB+","AB-","O+","O-"])],


        ];
    }
}
