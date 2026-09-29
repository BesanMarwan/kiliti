<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "RateResource",
    title: "Rate Response",
    type: "object",

    properties: [

        new OA\Property(
            property: "id",
            type: "integer",
            format: "int64",
            description: "user id"
        ),
        new OA\Property(
            property: "rate",
            type: "number",
            description: "rate number"
        ),

        new OA\Property(
            property: "comment",
            type: "string",
            description: "comment about application"
        )
    ],

    example: [
        "rateObj" => [
            "id" => "1",
            "rate" => 4,
            "comment" => "comment about application"
    ]]
)]

class RateResource extends JsonResource
{

    public function toArray($request)
    {
        return  [
            'id' => (int) $this->id,
            'rate' => (int) $this->rate,
            'comment' => (string) $this->comment,
         ];
    }
}
