<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "HealthMeasurementSummaryResource",
    title: "Health Measurement Summary",
    description: "Latest health measurements for the authenticated patient.",
    type: "object",
    properties: [
        new OA\Property(
            property: "weight",
            type: "object",
            nullable: true,
            properties: [
                new OA\Property(
                    property: "value",
                    type: "number",
                    format: "float",
                    example: 63.2
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
                )
            ]
        ),
        new OA\Property(
            property: "blood_pressure",
            type: "object",
            nullable: true,
            properties: [
                new OA\Property(
                    property: "systolic",
                    type: "number",
                    format: "float",
                    example: 128
                ),
                new OA\Property(
                    property: "diastolic",
                    type: "number",
                    format: "float",
                    example: 82
                ),
                new OA\Property(
                    property: "unit",
                    type: "string",
                    example: "mmHg"
                ),
                new OA\Property(
                    property: "measured_at",
                    type: "string",
                    format: "date-time",
                    example: "2026-09-24 09:30:00"
                )
            ]
        ),
        new OA\Property(
            property: "heart_rate",
            type: "object",
            nullable: true,
            properties: [
                new OA\Property(
                    property: "value",
                    type: "number",
                    format: "float",
                    example: 78
                ),
                new OA\Property(
                    property: "unit",
                    type: "string",
                    example: "bpm"
                ),
                new OA\Property(
                    property: "measured_at",
                    type: "string",
                    format: "date-time",
                    example: "2026-09-24 09:30:00"
                )
            ]
        )
    ]
)]
class HealthMeasurementSummaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $weight = $this->resource['weight'];
        $bloodPressure = $this->resource['blood_pressure'];
        $heartRate = $this->resource['heart_rate'];

        return [
            'weight' => $weight ? [
                'value' => (float) $weight->value,
                'unit' => $weight->unit,
                'measured_at' => $weight->measured_at,
            ] : null,

            'blood_pressure' => $bloodPressure ? [
                'systolic' => (float) $bloodPressure->value,
                'diastolic' => (float) $bloodPressure->value_secondary,
                'unit' => $bloodPressure->unit,
                'measured_at' => $bloodPressure->measured_at,
            ] : null,

            'heart_rate' => $heartRate ? [
                'value' => (float) $heartRate->value,
                'unit' => $heartRate->unit,
                'measured_at' => $heartRate->measured_at,
            ] : null,
        ];
    }
}
