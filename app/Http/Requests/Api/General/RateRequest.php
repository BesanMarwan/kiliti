<?php

namespace App\Http\Requests\Api\General;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ApplicationRate",
    title: "ApplicationRate",
    required: ["rate", "comment"],
    properties: [
        new OA\Property(
            property: "rate",
            description: "rate number 1,2,3,4,5",
            type: "number"
        ),

        new OA\Property(
            property: "comment",
            description: "any comment about application",
            type: "string"
        )
    ]
)]
class RateRequest extends FormRequest
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
       return  [
            'rate'    => ['required','numeric','min:1','max:5'],
            'comment' => ['required','string'],
        ];
    }
}
