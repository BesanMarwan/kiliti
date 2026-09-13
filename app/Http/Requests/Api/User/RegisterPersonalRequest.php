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
    required: ["birth_date", "gender", "blood_type","dialysis_start_date", "dialysis_type", "sessions_per_week"],
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
        new OA\Property(
            property: "dialysis_start_date",
            description: "dialysis start date",
            type: "string",
            format: "date"
        ),
        new OA\Property(
            property: "dialysis_type",
            description: " disease type",
            type: "string",
            enum: ["hemodialysis", "peritoneal"]
        ),
        new OA\Property(
            property: "sessions_per_week",
            description: "number sessions per week",
            type: "number",
        ),
        new OA\Property(
            property: "center_id",
            description: "send center  id ",
            type: "number",
        ),
        new OA\Property(
            property: "doctor_id",
            description: "send doctor  id ",
            type: "number",
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
            'birth_date'          => ['required', 'date','before:today'],
            'gender'              => ['required', Rule::in(["male","female"])],
            'blood_type'          => ['required', Rule::in(["A+","A-","B+","B-","AB+","AB-","O+","O-"])],
            'dialysis_start_date' => ['required', 'date', 'before_or_equal:today'],
            'dialysis_type'       => ['required', Rule::in(['hemodialysis', 'peritoneal']),],
            'sessions_per_week'   => ['required', 'integer', 'min:1', 'max:7',],
            'center_id'           => ['required',Rule::exists('dialysis_centers','id')],
            'doctor_id'           => ['required',Rule::exists('doctors','id')],

        ];
    }


}
