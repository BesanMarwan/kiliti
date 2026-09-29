<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "PatientMedicationScheduleResponseResource",
    type: "object",
    properties: [
        new OA\Property(
            property: "date",
            type: "string",
            format: "date",
            example: "2026-09-26"
        ),

        new OA\Property(
            property: "period",
            type: "string",
            enum: [
                "all",
                "morning",
                "afternoon",
                "evening"
            ],
            example: "morning"
        ),

        new OA\Property(
            property: "adherence",
            type: "object",
            properties: [
                new OA\Property(
                    property: "total",
                    type: "integer",
                    example: 4
                ),

                new OA\Property(
                    property: "taken",
                    type: "integer",
                    example: 3
                ),

                new OA\Property(
                    property: "percentage",
                    type: "integer",
                    example: 75
                ),
            ]
        ),

        new OA\Property(
            property: "medications",
            type: "array",
            items: new OA\Items(
                ref: "#/components/schemas/PatientMedicationScheduleResource"
            )
        ),
    ]
)]
class PatientMedicationScheduleResponseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'date'        => $this->resource['date'],
            'period'      => $this->resource['period'],
            'adherence'   => $this->resource['adherence'],
            'medications' => PatientMedicationScheduleResource::collection($this->resource['medications']),
        ];
    }
}
