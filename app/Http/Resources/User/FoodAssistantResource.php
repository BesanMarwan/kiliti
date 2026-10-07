<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodAssistantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'query' => $this->resource['query'] ?? null,

            'food' => $this->resource['food'] ?? null,

            'nutrients' => [
                'potassium' => $this->resource['nutrients']['potassium'] ?? null,
                'phosphorus' => $this->resource['nutrients']['phosphorus'] ?? null,
                'sodium' => $this->resource['nutrients']['sodium'] ?? null,
            ],

            'guidance' => $this->resource['guidance'] ?? null,

            'alternatives' => $this->resource['alternatives'] ?? [],
        ];
    }
}
