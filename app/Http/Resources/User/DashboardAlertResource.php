<?php

namespace App\Http\Resources\User;

use App\Http\Resources\General\GeneralDataResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'DashboardAlertResource',
    type: 'object',
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
            example: 15
        ),
        new OA\Property(
            property: 'type',
            type: 'string',
            example: 'fluid_limit_exceeded'
        ),
        new OA\Property(
            property: 'severity',
            type: 'string',
            example: 'warning'
        ),
        new OA\Property(
            property: 'title',
            type: 'string',
            example: 'تنبيه السوائل'
        ),
        new OA\Property(
            property: 'message',
            type: 'string',
            example: 'لقد تجاوزت الحد اليومي المسموح من السوائل.'
        ),
        new OA\Property(
            property: 'is_read',
            type: 'boolean',
            example: false
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            format: 'date-time',
            example: '2026-09-26T12:30:00+03:00'
        ),
    ]
)]
class DashboardAlertResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
//            'id' => $this->resource['id'] ?? null,
            'type' => $this->resource['type'] ?? null,
            'severity' => $this->resource['severity'] ?? null,
            'title' => $this->resource['title'] ?? null,
            'message' => $this->resource['message'] ?? null,
            'priority' => $this->resource['priority'] ?? 0,
            'created_at' => $this->resource['created_at'] ?? null,
        ];
    }
}
