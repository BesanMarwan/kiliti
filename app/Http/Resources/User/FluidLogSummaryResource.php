<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "FluidLogSummaryResource",
    title: "Fluid Log Summary",
    description: "Today's fluid intake summary for the authenticated patient.",
    type: "object",
    properties: [
        new OA\Property(
            property: "daily_limit_ml",
            type: "number",
            format: "float",
            example: 1500
        ),
        new OA\Property(
            property: "consumed_ml",
            type: "number",
            format: "float",
            example: 850
        ),
        new OA\Property(
            property: "remaining_ml",
            type: "number",
            format: "float",
            example: 650
        ),
        new OA\Property(
            property: "percentage",
            type: "number",
            format: "float",
            example: 56.67
        ),
        new OA\Property(
            property: "is_exceeded",
            type: "boolean",
            example: false
        )
    ]
)]
class FluidLogSummaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'daily_limit_ml' => $this->resource['daily_limit_ml'],
            'consumed_ml'    => $this->resource['consumed_ml'],
            'remaining_ml'   => $this->resource['remaining_ml'],
            'percentage'     => $this->resource['percentage'],
            'is_exceeded'    => $this->resource['is_exceeded'],
        ];
    }
}
