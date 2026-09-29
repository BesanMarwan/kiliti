<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class FamilyInvitationResource extends JsonResource
{


    #[OA\Schema(
        schema: "FamilyInvitation",
        title: "FamilyInvitation",
        description: "Public information about a family invitation",
        type: "object",


        properties: [

            new OA\Property(
                property: "id",
                type: "integer",
                format: "int64",
                description: "Invitation  ID"
            ),

            new OA\Property(
                property: "status",
                type: "string",
                enum: ["pending", "accepted", "rejected", "expired", "cancelled",],
                description: "invitation status"
            ),

            new OA\Property(
                property: "patient_name",
                type: "string",
                description: "Patient name"
            ),


            new OA\Property(
                property: "mobile",
                type: "string",
                nullable: true,
                description: "Doctor mobile number"
            ),

            new OA\Property(
                property: "relationship",
                type: "string",
                description: "Family Member relationship"
            ),

            new OA\Property(
                property: "expires_at",
                type: "string",
                nullable: true,
                format: "date-time",
            ),
            new OA\Property(
                property: "next_step",
                type: "string",
                enum: ["login", "register"],
                nullable: true,
                example: "register"
            ),

        ],

        example: [
            "id" => 1,
            "status" => 'pending',
            "patient_name" => "Besan",
            "mobile" => "0597501686",
            "relationship" => "sister",
            "expires_at" => "2026-09-26T18:56:00.000000Z",
            "next_step" => "register",
        ]
    )]
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'    =>$this->id,
            'status' => $this->status?->value,
//            'name'  =>$this->name,
            'patient_name' => $this->patient?->user?->name,
            'relationship' => $this->relationship,
            'mobile' => $this->mobile,
            'expires_at' => $this->expires_at?->toISOString(),
            'next_step'=>User::where('mobile', $this->mobile)->exists() ? 'login' : 'register',
        ];
    }
}
