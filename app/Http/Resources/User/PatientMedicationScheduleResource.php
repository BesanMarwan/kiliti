<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "PatientMedicationScheduleResource",
    type: "object",
    properties: [
        new OA\Property(
            property: "log_id",
            type: "integer",
            example: 15
        ),

        new OA\Property(
            property: "patient_medication_id",
            type: "integer",
            example: 8
        ),

        new OA\Property(
            property: "medication",
            type: "object",
            properties: [
                new OA\Property(
                    property: "id",
                    type: "integer",
                    example: 2
                ),

                new OA\Property(
                    property: "name",
                    type: "string",
                    example: "Renvela"
                ),
            ]
        ),

        new OA\Property(
            property: "dosage",
            type: "string",
            nullable: true,
            example: "800mg"
        ),

        new OA\Property(
            property: "frequency",
            type: "string",
            nullable: true,
            example: "3 times daily"
        ),

        new OA\Property(
            property: "route",
            type: "string",
            nullable: true,
            example: "Oral"
        ),

        new OA\Property(
            property: "instructions",
            type: "string",
            nullable: true,
            example: "Take with meals"
        ),

        new OA\Property(
            property: "scheduled_at",
            type: "string",
            format: "date-time",
            example: "2026-09-26 08:00"
        ),

        new OA\Property(
            property: "taken_at",
            type: "string",
            format: "date-time",
            nullable: true,
            example: "2026-09-26 08:05"
        ),

        new OA\Property(
            property: "status",
            type: "string",
            enum: [
                "pending",
                "taken",
                "snoozed",
                "missed",
                "skipped"
            ],
            example: "taken"
        ),

        new OA\Property(
            property: "snoozed_until",
            type: "string",
            format: "date-time",
            nullable: true,
            example: null
        ),
    ]
)]
class PatientMedicationScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'log_id'                => $this->id,
            'patient_medication_id' => $this->patient_medication_id,
            'medication' => [
                'id' => $this->patientMedication->medication->id,
                'name' => $this->patientMedication->medication->name,
                'category' => $this->patientMedication->medication->category?->name,
            ],

            'dosage'                  => $this->patientMedication->dosage,
            'frequency'               => $this->patientMedication->frequency,
            'route'                   => optional($this->patientMedication->routeObj)->name,
            'instructions'            => $this->patientMedication->instructions,
            'scheduled_at'            => $this->scheduled_at ? $this->scheduled_at->setTimezone('Asia/Gaza')->format('Y-m-d H:i a') : null,
            'taken_at'                => $this->taken_at ? $this->taken_at->setTimezone('Asia/Gaza')->format('Y-m-d H:i') : null,
            'status'                  => $this->status,
            'snoozed_until'           => $this->snoozed_until ? $this->snoozed_until->setTimezone('Asia/Gaza')->format('Y-m-d H:i') : null,
        ];
    }
}
