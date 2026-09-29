<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: "SymptomResource",
    title: "Symptom Resource",
    type: "object",

    properties: [

        new OA\Property(
            property: "id",
            type: "integer",
            format: "int64",
            description: "Symptom ID"
        ),

        new OA\Property(
            property: "name",
            type: "string",
            description: "Symptom name"
        ),
        new OA\Property(
            property: "description",
            type: "string",
            description: "Symptom description"
        ),
        new OA\Property(
            property: "is_critical",
            type: "number",
            description: "the Sympotom is critical or not"
        ),

    ],

    example: [
        "id" => 1,
        "name" => "ألم في الصدر",
        "description" => "شعور بألم أو ضغط في منطقة الصدر، ويُعد من الأعراض الحرجة التي تتطلب انتباهًا طبيًا فوريًا.",
        "is_critical" => 1,


    ]
)]

class SymptomResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_critical' => (bool) $this->is_critical,
        ];

    }
}
