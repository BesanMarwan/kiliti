<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use App\Rules\PasswordPolicy;
use App\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "RegisterMedicalInfo",
    title: "RegisterMedicalInfo",
    required: ["dialysis_start_date", "dialysis_type", "sessions_per_week"],
    properties: [
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
    ]
)]
class RegisterMedicalInfoRequest extends FormRequest
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
            'dialysis_start_date' => ['required', 'date', 'before_or_equal:today'],
            'dialysis_type'      => ['required', Rule::in(['hemodialysis', 'peritoneal']),],
            'sessions_per_week' => ['required', 'integer', 'min:1', 'max:7',],
        ];
    }


}
