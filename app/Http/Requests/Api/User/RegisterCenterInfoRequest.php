<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use App\Rules\PasswordPolicy;
use App\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "RegisterCenterInfo",
    title: "RegisterCenterInfo",
    required: ["center_id"],
    properties: [
        new OA\Property(
            property: "center_id",
            description: "send center  id ",
            type: "number",
        ),

    ]
)]
class RegisterCenterInfoRequest extends FormRequest
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
            'center_id' => ['required',Rule::exists('dialysis_centers','id')],

        ];
    }


}
