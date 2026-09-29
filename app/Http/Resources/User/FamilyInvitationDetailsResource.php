<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "FamilyInvitationDetails",
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
            property: "relationship",
            type: "string",
            nullable: true,
            example: "brother"
        ),

        new OA\Property(
            property: "status",
            type: "string",
            enum: [
                "pending",
                "accepted",
                "rejected",
                "expired",
                "cancelled"
            ],
            example: "accepted"
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

        new OA\Property(
            property: "family_member",
            nullable: true,
            properties: [

                new OA\Property(
                    property: "id",
                    type: "integer",
                    example: 7
                ),

                new OA\Property(
                    property: "user_id",
                    type: "integer",
                    example: 25
                ),

                new OA\Property(
                    property: "name",
                    type: "string",
                    example: "Ahmed Ali"
                ),

                new OA\Property(
                    property: "mobile",
                    type: "string",
                    example: "059XXXXXXX"
                ),

                new OA\Property(
                    property: "status",
                    type: "string",
                    example: "active"
                ),

            ],
            type: "object"
        ),

        new OA\Property(
            property: "permissions",
            type: "array",
            items: new OA\Items(
                properties: [

                    new OA\Property(
                        property: "id",
                        type: "integer",
                        example: 1
                    ),

                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "view_medications"
                    ),

                    new OA\Property(
                        property: "label",
                        type: "string",
                        example: "View Medications"
                    ),

                ],
                type: "object"
            )
        ),
    ]
)]

class FamilyInvitationDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'mobile' => $this->mobile,

            'relationship' => $this->relationship,

            'status' => $this->status?->value,

            'expires_at' => $this->expires_at?->toISOString(),

            'accepted_at' => $this->accepted_at?->toISOString(),

            'created_at' => $this->created_at?->toISOString(),

            'family_member' => $this->when(
                $this->familyMember !== null,
                fn () => [
                    'id' => $this->familyMember->id,

                    'user_id' => $this->familyMember->user?->id,

                    'name' => $this->familyMember->user?->name,

                    'mobile' => $this->familyMember->user?->mobile,

                    'status' => $this->patientFamilyMember?->status,
                ]
            ),

            'permissions' => $this->when(
                $this->patientFamilyMember !== null,
                fn () => $this->patientFamilyMember
                    ->permissions
                    ->map(fn ($permission) => [
                        'id' => $permission->permission_type_id,
                        'name' => $permission->permissionType?->name,
                        'label' => $permission->permissionType?->label,
                    ])
                    ->values()
            ),
        ];
    }
}
