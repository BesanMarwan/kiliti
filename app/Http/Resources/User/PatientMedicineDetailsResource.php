<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class PatientMedicineDetailsResource extends JsonResource
{

    #[OA\Schema(
        schema: "PatientMedicineDetails",
        type: "object",
        required: [
            "id",
            "name",
            "description",
            "important_alert",
            "category",
            "dosage",
            "frequency",
            "frequency_label",
            "route",
            "next_dose_time",
            "reminder_times",
            "reminder_enabled",
            "doctor_name",
            "status",
            "status_label",
            "start_date",
            "end_date",
            "daily_doses"
        ],
        properties: [
            new OA\Property(
                property: "id",
                type: "integer",
                example: 7699
            ),

            new OA\Property(
                property: "name",
                type: "string",
                example: "فروسيميد"
            ),

            new OA\Property(
                property: "description",
                type: "string",
                example: "مدر للبول يساعد على التخلص من السوائل الزائدة."
            ),

            new OA\Property(
                property: "important_alert",
                type: "string",
                nullable: true,
                example: "يجب الالتزام بالجرعة المحددة من الطبيب."
            ),

            new OA\Property(
                property: "category",
                type: "string",
                nullable: true,
                example: "مدرات البول"
            ),

            new OA\Property(
                property: "dosage",
                type: "string",
                example: "40 mg"
            ),

            new OA\Property(
                property: "frequency",
                type: "string",
                enum: [
                    "once_daily",
                    "twice_daily",
                    "three_times_daily",
                    "four_times_daily",
                    "every_12_hours",
                    "every_8_hours",
                    "every_6_hours",
                    "as_needed"
                ],
                example: "twice_daily"
            ),

            new OA\Property(
                property: "frequency_label",
                type: "string",
                example: "مرتين يوميًا"
            ),

            new OA\Property(
                property: "route",
                type: "object",
                nullable: true,
                description: "Medication administration route.",
                example: [
                    "id" => 1,
                    "name" => "عن طريق الفم"
                ]
            ),

            new OA\Property(
                property: "next_dose_time",
                type: "string",
                nullable: true,
                format: "time",
                example: "08:00"
            ),

            new OA\Property(
                property: "reminder_times",
                type: "array",
                items: new OA\Items(
                    type: "string",
                    example: "08:00"
                ),
                example: [
                    "08:00",
                    "20:00"
                ]
            ),

            new OA\Property(
                property: "reminder_enabled",
                type: "boolean",
                example: true
            ),

            new OA\Property(
                property: "doctor_name",
                type: "string",
                nullable: true,
                example: "د. أحمد محمد"
            ),

            new OA\Property(
                property: "status",
                type: "string",
                enum: [
                    "active",
                    "stopped",
                    "completed"
                ],
                example: "active"
            ),

            new OA\Property(
                property: "status_label",
                type: "string",
                example: "نشط"
            ),

            new OA\Property(
                property: "start_date",
                type: "string",
                format: "date",
                nullable: true,
                example: "2026-10-01"
            ),

            new OA\Property(
                property: "end_date",
                type: "string",
                format: "date",
                nullable: true,
                example: "2026-12-01"
            ),

            new OA\Property(
                property: "daily_doses",
                type: "array",
                items: new OA\Items(
                    ref: "#/components/schemas/MedicationLog"
                )
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
            'id' => $this->id,
            'name' => $this->medication?->name ?? "",
            'description' => $this->medication?->description ?? "",
            'important_alert' => $this->medication?->important_alert ?? "",
            'category' => $this->medication?->category->name ?? null,
            'dosage' => $this->dosage,
            'frequency' => $this->frequency instanceof \BackedEnum
                ? $this->frequency->value
                : $this->frequency,

            'frequency_label' => $this->frequency instanceof \BackedEnum
                ? $this->frequency->label()
                : match ($this->frequency) {
                    'once_daily' => 'مرة يوميًا',
                    'twice_daily' => 'مرتين يوميًا',
                    'three_times_daily' => '3 مرات يوميًا',
                    'four_times_daily' => '4 مرات يوميًا',
                    'every_12_hours' => 'كل 12 ساعة',
                    'every_8_hours' => 'كل 8 ساعات',
                    'every_6_hours' => 'كل 6 ساعات',
                    'as_needed' => 'عند الحاجة',
                    default => $this->frequency,
                },
            'route' => $this->routeObj,
            'next_dose_time' => $this->next_dose_time->format('H:i'),
            'reminder_times' => $this->reminder_times,
            'reminder_enabled' => $this->reminder_enabled,
            'doctor_name' => $this->doctor?->user->name,
            'status' => $this->status,
            'status_label' => match ($this->status) {
                'active' => 'نشط',
                'stopped' => 'متوقف',
                'completed' => 'مكتمل',
                default => $this->status,
            },
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'daily_doses' => MedicationLogResource::collection(
                $this->whenLoaded('medicationLogs')
            ),
        ];
    }
}
