<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "HealthMeasurementResource",
    title: "Health Measurement",
    description: "A single health measurement recorded by the patient.",
    type: "object",
    properties: [
        new OA\Property(
            property: "id",
            type: "integer",
            example: 15
        ),
        new OA\Property(
            property: "type",
            type: "string",
            example: "weight",
            enum: [
                "weight",
                "blood_pressure",
                "heart_rate",
                "temperature",
                "blood_sugar"
            ]
        ),
        new OA\Property(
            property: "value",
            type: "number",
            format: "float",
            example: 63.2
        ),
        new OA\Property(
            property: "value_secondary",
            type: "number",
            format: "float",
            nullable: true,
            example: null
        ),
        new OA\Property(
            property: "unit",
            type: "string",
            example: "kg"
        ),
        new OA\Property(
            property: "measured_at",
            type: "string",
            format: "date-time",
            example: "2026-09-24 09:30:00"
        ),
        new OA\Property(
            property: "notes",
            type: "string",
            nullable: true,
            example: "Morning measurement."
        )
    ]
)]
class HealthMeasurementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'type'            => $this->type,
            'value'           => (float) $this->value,
            'value_secondary' => $this->value_secondary !== null ? (float) $this->value_secondary : null,
            'unit'            => $this->unit,
            'measured_at'     => $this->measured_at,
            'notes'           => $this->notes,
        ];
    }
}
