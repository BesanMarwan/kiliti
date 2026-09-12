<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use App\Rules\PasswordPolicy;
use App\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "RegisterPersonal",
    title: "RegisterPersonal",
    required: ["birth_date", "gender", "blood_type"],
    properties: [
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
class RegisterPersonalRequest extends FormRequest
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
            'birth_date' => ['required', 'date','before:today'],
            'gender'     => ['required', Rule::in(["male","female"])],
            'blood_type' => ['required', Rule::in(["A+","A-","B+","B-","AB+","AB-","O+","O-"])],
        ];
    }


}
