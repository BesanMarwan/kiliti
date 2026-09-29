<?php

namespace App\Http\Resources\User;

use App\Http\Resources\General\GeneralDataResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "DoctorConsultationResource",
    title: "Doctor Consultation Resource",
    properties: [
        new OA\Property(
            property: "id",
            type: "integer",
            example: 1
        ),

        new OA\Property(
            property: "doctor",
            type: "object",
            properties: [
                new OA\Property(
                    property: "id",
                    type: "integer",
                    example: 3
                ),
                new OA\Property(
                    property: "name",
                    type: "string",
                    example: "د. طارق المنصور"
                ),
                new OA\Property(
                    property: "specialization",
                    type: "string",
                    example: "استشاري أمراض وزراعة الكلى"
                ),
            ]
        ),

        new OA\Property(
            property: "type",
            type: "object",
            items: new OA\Items(
                ref: "#/components/schemas/GeneralDataResource"
            )
        ),

        new OA\Property(
            property: "message",
            type: "string",
            example: "أشعر بالتعب بعد جلسة الغسيل"
        ),

        new OA\Property(
            property: "status",
            type: "string",
            enum: [
                "pending",
                "answered",
                "closed"
            ],
            example: "pending"
        ),

        new OA\Property(
            property: "answer",
            type: "string",
            nullable: true,
            example: "يرجى متابعة الضغط والتواصل مع المركز إذا استمرت الأعراض."
        ),

        new OA\Property(
            property: "sent_at",
            type: "string",
            format: "date-time"
        ),

        new OA\Property(
            property: "answered_at",
            type: "string",
            format: "date-time",
            nullable: true
        ),

        new OA\Property(
            property: "created_at",
            type: "string",
            format: "date-time"
        ),
    ],
    type: "object"
)]
class DoctorConsultationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'doctor' => $this->whenLoaded('doctor', function () {
                return [
                    'id' => $this->doctor->id,
                    'name' => $this->doctor->user?->name,
                    'avatar' => $this->doctor->user?->image_url,
                    'specialization' => $this->doctor->specialization,
                ];
            }),

            'consultation_type' => GeneralDataResource::make($this->consultation_type_object),
            'message'           => $this->message,
            'status'            => $this->status,
            'status_title'      => $this->status_title,
            'answer'            => $this->answer,
            'sent_at'           => $this->sent_at?->toIso8601String(),
            'answered_at'       => $this->answered_at?->toIso8601String(),
            'created_at'        => $this->created_at?->toIso8601String(),
        ];
    }
}
