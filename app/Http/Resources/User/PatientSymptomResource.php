<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: "Symptom Resource",
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

class PatientSymptomResource extends JsonResource
{
    #[OA\Schema(
        schema: "PatientSymptomResource",
        type: "object",
        properties: [
            new OA\Property(
                property: "id",
                type: "integer",
                example: 1
            ),

            new OA\Property(
                property: "symptom",
                ref: "#/components/schemas/SymptomResource"
            ),

            new OA\Property(
                property: "severity",
                type: "integer",
                minimum: 1,
                maximum: 5,
                example: 4
            ),

            new OA\Property(
                property: "recorded_at",
                type: "string",
                format: "date-time",
                example: "2026-09-28T13:30:00+03:00"
            ),

            new OA\Property(
                property: "notes",
                type: "string",
                nullable: true,
                example: "Feeling shortness of breath after dialysis."
            ),

            new OA\Property(
                property: "is_critical",
                type: "boolean",
                example: true
            ),

            new OA\Property(
                property: "created_at",
                type: "string",
                format: "date-time"
            ),
        ]
    )]

    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'symptom'     => new SymptomResource($this->whenLoaded('symptom')),
            'severity'    => $this->severity,
            'recorded_at' => $this->recorded_at?->toISOString(),
            'notes'       => $this->notes,
            'created_at'  => $this->created_at?->toISOString(),
        ];

    }
}
