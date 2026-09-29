<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "DialysisSessionDetailsResource",
    title: "Dialysis Session Details Resource",
    description: "Detailed dialysis session information including session record.",
    properties: [
        new OA\Property(
            property: "id",
            type: "integer",
            example: 15
        ),

        new OA\Property(
            property: "scheduled_at",
            type: "string",
            example: "2026-09-27 14:00:00"
        ),

        new OA\Property(
            property: "started_at",
            type: "string",
            nullable: true,
            example: "2026-09-27 14:10:00"
        ),

        new OA\Property(
            property: "ended_at",
            type: "string",
            nullable: true,
            example: "2026-09-27 18:00:00"
        ),

        new OA\Property(
            property: "status",
            type: "string",
            enum: [
                "scheduled",
                "confirmed",
                "completed",
                "missed",
                "cancelled"
            ],
            example: "completed"
        ),

        new OA\Property(
            property: "session_type",
            type: "string",
            enum: [
                "hemodialysis",
                "peritoneal",
                "other"
            ],
            example: "hemodialysis"
        ),

        new OA\Property(
            property: "center",
            type: "object",
            nullable: true,
            properties: [
                new OA\Property(
                    property: "id",
                    type: "integer",
                    example: 3
                ),
                new OA\Property(
                    property: "name",
                    type: "string",
                    example: "Al-Shifa Dialysis Center"
                ),
                new OA\Property(
                    property: "city",
                    type: "string",
                    nullable: true,
                    example: "Gaza"
                ),
                new OA\Property(
                    property: "address",
                    type: "string",
                    nullable: true,
                    example: "Al-Rimal"
                ),
            ],
        ),

        new OA\Property(
            property: "doctor",
            type: "object",
            nullable: true,
            properties: [
                new OA\Property(
                    property: "id",
                    type: "integer",
                    example: 7
                ),
                new OA\Property(
                    property: "name",
                    type: "string",
                    example: "Dr. Ahmad"
                ),
            ],
        ),

        new OA\Property(
            property: "notes",
            type: "string",
            nullable: true
        ),

        new OA\Property(
            property: "doctor_instructions",
            type: "string",
            nullable: true
        ),

        new OA\Property(
            property: "record",
            type: "object",
            nullable: true,
            properties: [
                new OA\Property(
                    property: "pre_weight",
                    type: "number",
                    format: "float",
                    nullable: true,
                    example: 72.50
                ),

                new OA\Property(
                    property: "post_weight",
                    type: "number",
                    format: "float",
                    nullable: true,
                    example: 70.80
                ),

                new OA\Property(
                    property: "blood_pressure_before",
                    type: "object",
                    nullable: true,
                    properties: [
                        new OA\Property(
                            property: "systolic",
                            type: "integer",
                            nullable: true,
                            example: 140
                        ),
                        new OA\Property(
                            property: "diastolic",
                            type: "integer",
                            nullable: true,
                            example: 85
                        ),
                    ]
                ),

                new OA\Property(
                    property: "blood_pressure_after",
                    type: "object",
                    nullable: true,
                    properties: [
                        new OA\Property(
                            property: "systolic",
                            type: "integer",
                            nullable: true,
                            example: 130
                        ),
                        new OA\Property(
                            property: "diastolic",
                            type: "integer",
                            nullable: true,
                            example: 80
                        ),
                    ]
                ),

                new OA\Property(
                    property: "heart_rate",
                    type: "integer",
                    nullable: true,
                    example: 78
                ),

                new OA\Property(
                    property: "fluid_removed_ml",
                    type: "number",
                    format: "float",
                    nullable: true,
                    example: 1700
                ),

                new OA\Property(
                    property: "session_notes",
                    type: "string",
                    nullable: true
                ),
            ]
        ),
    ]
)]
class DialysisSessionDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'scheduled_at' => $this->scheduled_at?->format('Y-m-d H:i:s'),

            'started_at' => $this->started_at?->format('Y-m-d H:i:s'),

            'ended_at' => $this->ended_at?->format('Y-m-d H:i:s'),

            'status' => $this->status,

            'session_type' => $this->session_type,

            'center' => $this->whenLoaded('center', function () {
                return $this->center ? [
                    'id' => $this->center->id,
                    'name' => $this->center->name,
                    'city' => $this->center->city,
                    'address' => $this->center->address,
                ] : null;
            }),

            'doctor' => $this->whenLoaded('doctor', function () {
                return $this->doctor ? [
                    'id' => $this->doctor->id,
                    'name' => $this->doctor->user?->name,
                ] : null;
            }),

            'notes' => $this->notes,

            'doctor_instructions' => $this->doctor_instructions,

            'record' => $this->whenLoaded('record', function () {
                if (!$this->record) {
                    return null;
                }

                return [
                    'pre_weight' => $this->record->pre_weight,
                    'post_weight' => $this->record->post_weight,

                    'blood_pressure_before' => [
                        'systolic' =>
                            $this->record->blood_pressure_before_systolic,

                        'diastolic' =>
                            $this->record->blood_pressure_before_diastolic,
                    ],

                    'blood_pressure_after' => [
                        'systolic' =>
                            $this->record->blood_pressure_after_systolic,

                        'diastolic' =>
                            $this->record->blood_pressure_after_diastolic,
                    ],

                    'heart_rate' => $this->record->heart_rate,

                    'fluid_removed_ml' =>
                        $this->record->fluid_removed_ml,

                    'session_notes' =>
                        $this->record->session_notes,
                ];
            }),
        ];
    }
}
