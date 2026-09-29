<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class DialysisSessionIssueResource extends JsonResource
{
    #[OA\Schema(
        schema: "DialysisSessionIssueResource",
        title: "Dialysis Session Issue Resource",
        description: "Patient reported issue during a dialysis session",
        properties: [
            new OA\Property(
                property: "id",
                type: "integer",
                example: 1
            ),

            new OA\Property(
                property: "dialysis_session_id",
                type: "integer",
                example: 15
            ),

            new OA\Property(
                property: "issue_type",
                type: "string",
                enum: [
                    "dizziness",
                    "severe_fatigue",
                    "nausea_pain",
                    "cramps",
                    "machine_problem",
                    "needle_problem",
                    "other"
                ],
                example: "dizziness"
            ),

            new OA\Property(
                property: "severity",
                type: "string",
                enum: [
                    "mild",
                    "moderate",
                    "severe"
                ],
                example: "moderate"
            ),

            new OA\Property(
                property: "description",
                type: "string",
                nullable: true,
                example: "أشعر بدوخة أثناء الجلسة"
            ),

            new OA\Property(
                property: "reported_at",
                type: "string",
                format: "date-time",
                example: "2026-09-28T14:30:00+03:00"
            ),

            new OA\Property(
                property: "status",
                type: "string",
                enum: [
                    "open",
                    "acknowledged",
                    "resolved"
                ],
                example: "open"
            ),

            new OA\Property(
                property: "created_at",
                type: "string",
                format: "date-time",
                example: "2026-09-28T14:30:00+03:00"
            ),

            new OA\Property(
                property: "updated_at",
                type: "string",
                format: "date-time",
                example: "2026-09-28T14:30:00+03:00"
            ),
        ],
        type: "object"
    )]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'dialysis_session_id' => $this->dialysis_session_id,

            'issue_type' => $this->issue_type,

            'severity' => $this->severity,

            'description' => $this->description,

            'reported_at' => $this->reported_at?->toIso8601String(),

            'status' => $this->status,

            'created_at' => $this->created_at?->toIso8601String(),

            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
