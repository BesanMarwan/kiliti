<?php

namespace App\Http\Requests\Api\General;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Parameter(
    parameter: "language",
    name: "language",
    description: "response language : ar for arabic || en for english",
    required: false,
    in: "header",

    schema: new OA\Schema(
        type: "string"
    ),

    examples: [
        new OA\Examples(
            example: "ar",
            summary: "Arabic",
            value: "ar"
        ),

        new OA\Examples(
            example: "en",
            summary: "English",
            value: "en"
        )
    ]
)]

#[OA\Parameter(
    parameter: "device_key",
    name: "device_key",
    description: "mobile device key used for firebase notifications",
    required: false,
    in: "header",

    schema: new OA\Schema(
        type: "string"
    )
)]

#[OA\Parameter(
    parameter: "device_name",
    name: "device_name",
    description: "user device name",
    required: false,
    in: "header",

    schema: new OA\Schema(
        type: "string"
    )
)]

#[OA\Parameter(
    parameter: "device_type",
    name: "device_type",
    description: "user device type android or ios",
    required: false,
    in: "header",

    schema: new OA\Schema(
        type: "string"
    )
)]

class DefaultHeaderRequest extends FormRequest
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
            //
        ];
    }
}
