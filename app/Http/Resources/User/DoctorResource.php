<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

use OpenApi\Attributes as OA;


#[OA\Schema(
    schema: "Doctor Resource",
    title: "Doctor Resource",
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
class DoctorResource extends JsonResource
{

    public function toArray($request)
    {
        $user =  [
            "id" => (int) $this->id,
            "user_id" =>  (int) $this->user_id,
            "name" =>(string) $this->user->name,
            "mobile" => (string) $this->user->mobile,
            "specialization" => $this->specialization,
            "license_number" => $this->license_number,
            "dialysis_center_id" => $this->dialysis_center_id,
        ];


        return $user;
    }
}
