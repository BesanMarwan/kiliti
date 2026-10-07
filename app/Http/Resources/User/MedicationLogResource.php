<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class MedicationLogResource extends JsonResource
{

    #[OA\Schema(
        schema: "MedicationLog",
        type: "object",
        required: [
            "id",
            "scheduled_at",
            "status",
            "status_label",
            "taken_at",
            "snoozed_until"
        ],
        properties: [
            new OA\Property(
                property: "id",
                type: "integer",
                example: 101
            ),

            new OA\Property(
                property: "scheduled_at",
                type: "string",
                format: "date-time",
                nullable: true,
                example: "2026-10-07T08:00:00+03:00"
            ),

            new OA\Property(
                property: "status",
                type: "string",
                enum: [
                    "pending",
                    "notified",
                    "taken",
                    "snoozed",
                    "missed",
                    "skipped"
                ],
                example: "taken"
            ),

            new OA\Property(
                property: "status_label",
                type: "string",
                example: "تم تناولها"
            ),

            new OA\Property(
                property: "taken_at",
                type: "string",
                format: "date-time",
                nullable: true,
                example: "2026-10-07T08:05:00+03:00"
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
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'scheduled_at' => $this->scheduled_at?->toISOString(),

            'status' => $this->status,

            'status_label' => match ($this->status) {
                'pending' => 'بانتظار الجرعة',
                'notified' => 'حان موعد الجرعة',
                'taken' => 'تم تناولها',
                'snoozed' => 'مؤجلة',
                'missed' => 'لم يتم تناولها',
                'skipped' => 'تم تخطيها',
                default => $this->status,
            },

            'taken_at' => $this->taken_at?->toISOString(),

            'snoozed_until' => $this->snoozed_until?->toISOString(),
        ];
    }
}
