<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "GeneralDataResource",
    title: "GeneralDataResource",
    properties: [
        new OA\Property(
            property: "id",
            type: "integer",
            format: "int64",
            description: "id"
        ),

        new OA\Property(
            property: "name",
            type: "string",
            description: "name"
        ),

        new OA\Property(
            property: "image",
            type: "string",
            description: "image"
        )
    ],
    type: "object",


//    example: [
//        "id" => 1231,
//        "name" => "Besan Marwan Abu Elkass",
//        "image" => "www.test.co/aaa.png"
//    ]
)]

class GeneralDataResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image_url ?? '',
        ];
    }
}
