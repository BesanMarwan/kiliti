<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class FluidLogResource extends JsonResource
{

    #[OA\Schema(
        schema: "FluidLogResource",
        type: "object",
        required: [
            "id",
            "fluid_type",
            "amount_ml",
            "fluid_limit",
            "recorded_at"
        ],
        properties: [
            new OA\Property(
                property: "id",
                type: "integer",
                example: 15
            ),
            new OA\Property(
                property: "fluid_type",
                type: "string",
                example: "water"
            ),

            new OA\Property(
                property: "amount_ml",
                type: "integer",
                example: 250
            ),

            new OA\Property(
                property: "fluid_limit",
                type: "integer",
                example: 1500
            ),

            new OA\Property(
                property: "recorded_at",
                type: "string",
                format: "date-time",
                example: "2026-10-07T09:30:00+03:00"
            ),

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
            'id'  => $this->id,
            'recorded_at' => $this->recorded_at,
            'amount_ml' => (integer)$this->amount_ml,
            'fluid_type' => $this->fluid_type ?? '',
        ];
    }
}
