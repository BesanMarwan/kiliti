<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;
class SmartNoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    #[OA\Schema(
        schema: 'SmartNoteResource',
        type: 'object',
        properties: [
            new OA\Property(
                property: 'type',
                type: 'string',
                example: 'success'
            ),
            new OA\Property(
                property: 'key',
                type: 'string',
                example: 'fluid_streak_3'
            ),
            new OA\Property(
                property: 'priority',
                type: 'integer',
                example: 90
            ),
            new OA\Property(
                property: 'title',
                type: 'string',
                example: 'ملاحظة ذكية'
            ),
            new OA\Property(
                property: 'message',
                type: 'string',
                example: 'أحسنت! حافظت على الحد المسموح به من السوائل لمدة 3 أيام متتالية. استمر بهذا الأداء الرائع 👏'
            ),
        ]
    )]
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
