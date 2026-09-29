<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "DialysisSessionResource",
    type: "object",
    description: "Patient dialysis session",
    properties: [
        new OA\Property(
            property: "id",
            type: "integer",
            example: 15
        ),

        new OA\Property(
            property: "scheduled_at",
            type: "string",
            format: "date-time",
            example: "2026-09-30 09:00:00"
        ),

        new OA\Property(
            property: "started_at",
            type: "string",
            format: "date-time",
            nullable: true,
            example: null
        ),

        new OA\Property(
            property: "ended_at",
            type: "string",
            format: "date-time",
            nullable: true,
            example: null
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
            example: "scheduled"
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
            properties: [
                new OA\Property(
                    property: "id",
                    type: "integer",
                    example: 2
                ),

                new OA\Property(
                    property: "name",
                    type: "string",
                    example: "مركز الأمل"
                ),

                new OA\Property(
                    property: "city",
                    type: "string",
                    nullable: true,
                    example: "غزة"
                ),

                new OA\Property(
                    property: "address",
                    type: "string",
                    nullable: true,
                    example: "شارع الوحدة"
                )
            ]
        ),

        new OA\Property(
            property: "doctor",
            type: "object",
            nullable: true,
            properties: [
                new OA\Property(
                    property: "id",
                    type: "integer",
                    example: 5
                ),

                new OA\Property(
                    property: "name",
                    type: "string",
                    example: "Dr. Ahmed"
                )
            ]
        ),

        new OA\Property(
            property: "notes",
            type: "string",
            nullable: true,
            example: null
        ),

        new OA\Property(
            property: "doctor_instructions",
            type: "string",
            nullable: true,
            example: "Arrive 15 minutes before the session."
        )
    ]
)]
class DialysisSessionResource extends JsonResource
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
                return [
                    'id' => $this->center?->id,
                    'name' => $this->center?->name,
                    'city' => $this->center?->city,
                    'address' => $this->center?->address,
                ];
            }),

            'doctor' => $this->whenLoaded('doctor', function () {
                return $this->doctor ? [
                    'id' => $this->doctor->id,
                    'name' => $this->doctor->user?->name,
                ] : null;
            }),

            'notes' => $this->notes,

            'doctor_instructions' => $this->doctor_instructions,
        ];
    }
}
