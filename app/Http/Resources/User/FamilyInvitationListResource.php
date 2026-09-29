<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "FamilyInvitationList",
    type: "object",
    properties: [
        new OA\Property(
            property: "id",
            type: "integer",
            example: 12
        ),
        new OA\Property(
            property: "mobile",
            type: "string",
            nullable: true,
            example: "059XXXXXXX"
        ),
        new OA\Property(
            property: "name",
            type: "string",
            nullable: true,
            example: "Besan"
        ),
        new OA\Property(
            property: "relationship",
            type: "string",
            nullable: true,
            example: "brother"
        ),
        new OA\Property(
            property: "status",
            type: "string",
            enum: ["pending", "accepted", "rejected", "expired", "cancelled"],
            example: "pending"
        ),
        new OA\Property(
            property: "expires_at",
            type: "string",
            format: "date-time",
            nullable: true,
            example: "2026-09-30T10:00:00Z"
        ),
        new OA\Property(
            property: "accepted_at",
            type: "string",
            format: "date-time",
            nullable: true,
            example: "2026-09-24T08:30:00Z"
        ),
        new OA\Property(
            property: "created_at",
            type: "string",
            format: "date-time",
            example: "2026-09-23T10:00:00Z"
        ),
    ]
)]
class FamilyInvitationListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'mobile' => $this->mobile,
            'name' => $this->name,
            'relationship' => $this->relationship,
            'status' => $this->status?->value,
            'expires_at' => $this->expires_at?->toISOString(),
            'accepted_at' => $this->accepted_at?->toISOString(),
            'is_accepted' => $this->accepted_at? 1:0,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
