<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use App\Rules\PasswordPolicy;
use App\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "RegisterDoctorInfo",
    title: "RegisterDoctorInfo",
    required: ["doctor_id"],
    properties: [
        new OA\Property(
            property: "doctor_id",
            description: "send doctor  id ",
            type: "number",
        ),

    ]
)]
class RegisterDoctorInfoRequest extends FormRequest
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
            'doctor_id' => ['required',Rule::exists('doctors','id')],

        ];
    }


}
