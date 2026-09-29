<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "FamilyPermissionType",
    type: "object",
    properties: [
        new OA\Property(
            property: "id",
            type: "integer",
            example: 12
        ),
        new OA\Property(
            property: "name",
            type: "string",
            example: "view_medicinne"
        ),
        new OA\Property(
            property: "label",
            type: "string",
            example: "مشاهدة سجل الادوية"
        ),
    ]
)]
class FamilyPermissionTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
             'name' => $this->name,
            'label' => $this->label
        ];
    }
}
