<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

use OpenApi\Attributes as OA;


#[OA\Schema(
    schema: "Family Member Resource",
    title: "Family Member Resource",
    type: "object",

    properties: [

        new OA\Property(
            property: "id",
            type: "integer",
            format: "int64",
            description: "Doctor ID"
        ),

        new OA\Property(
            property: "user_id",
            type: "integer",
            format: "int64",
            description: "User ID"
        ),

        new OA\Property(
            property: "name",
            type: "string",
            description: "Doctor name"
        ),

        new OA\Property(
            property: "email",
            type: "string",
            nullable: true,
            description: "Doctor email"
        ),

        new OA\Property(
            property: "mobile",
            type: "string",
            nullable: true,
            description: "Doctor mobile number"
        ),

        new OA\Property(
            property: "avatar",
            type: "string",
            nullable: true,
            description: "Doctor avatar URL"
        ),

        new OA\Property(
            property: "specialization",
            type: "string",
            nullable: true,
            description: "Doctor specialization"
        ),

        new OA\Property(
            property: "license_number",
            type: "string",
            nullable: true,
            description: "Doctor medical license number"
        ),

        new OA\Property(
            property: "status",
            type: "string",
            enum: [
                "not_verified",
                "enabled",
                "disabled"
            ],
            description: "Doctor account status"
        ),

        new OA\Property(
            property: "dialysis_center_id",
            type: "integer",
            format: "int64",
            description: "Dialysis center ID"
        ),
    ],

    example: [
        "id" => 1,
        "user_id" => 10,
        "name" => "Dr. Ahmad Mohammad",
        "mobile" => "0599000001",
        "specialization" => "Nephrology",
        "license_number" => "DOC-0001",
        "dialysis_center_id" => 1
    ]
)]
class FamilyMemberResource extends JsonResource
{

    public function toArray($request)
    {
        $user =  [
            "id"      => (int) $this->id,
           "userData" => [
               'id'     => $this->user->id,
               'name'   => $this->user->name,
               'mobile' => $this->user->mobile,
           ],
            "relationship"         =>(string) $this->relationship,
            "can_view_health_data" => $this->pivot->can_view_health_data ?? 0,
            "can_receive_alerts"   => $this->pivot->can_receive_alerts ?? 0,
        ];


        return $user;
    }
}
