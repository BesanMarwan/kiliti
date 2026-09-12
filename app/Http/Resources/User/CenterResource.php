<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: "Center Resource",
    title: "Center Resource",
    type: "object",

    properties: [

        new OA\Property(
            property: "id",
            type: "integer",
            format: "int64",
            description: "Dialysis center ID"
        ),

        new OA\Property(
            property: "name",
            type: "string",
            description: "Dialysis center name"
        ),
        new OA\Property(
            property: "doctors",
            type: "array",
            description: "Doctors working at this dialysis center",
            items: new OA\Items(
                ref: "#/components/schemas/Doctor Resource"
            )
        ),
    ],

    example: [
        "id" => 1,
        "name" => "مركز هند الدغمة لغسيل الكلى",

        "doctors" => [
            [
                "id" => 1,
                "user_id" => 10,
                "name" => "Dr. Ahmad Mohammad",
                "mobile" => "0599000001",
                "specialization" => "Nephrology",
                "license_number" => "DOC-0001",
                "status" => "enabled"
            ],
            [
                "id" => 2,
                "user_id" => 11,
                "name" => "Dr. Mohammad Ali",
                "mobile" => "0599000002",
                "specialization" => "Nephrology",
                "license_number" => "DOC-0002",
                "status" => "enabled"
            ]
        ]
    ]
)]

class CenterResource extends JsonResource
{

    public function toArray($request)
    {
         return  [
            'id' => (int) $this->id,
            'name' => (string) $this->name,
            'doctors' => DoctorResource::collection($this->doctors),
        ];

    }
}
