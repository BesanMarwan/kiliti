<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "UserResource",
    title: "User Response",
    type: "object",

    properties: [

        new OA\Property(
            property: "id",
            type: "integer",
            format: "int64",
            description: "user id"
        ),

        new OA\Property(
            property: "name",
            type: "string",
            description: "user name"
        ),

        new OA\Property(
            property: "email",
            type: "string",
            description: "user email"
        ),

        new OA\Property(
            property: "mobile",
            type: "string",
            description: "user mobile"
        ),

        new OA\Property(
            property: "status",
            type: "string",
            description: "user status not_verifed,enabled,disabled"
        ),

        new OA\Property(
            property: "avatar",
            type: "string",
            description: "user avatar url"
        ),

        new OA\Property(
            property: "accessToken",
            type: "string",
            description: "user Token"
        ),

        new OA\Property(
            property: "language",
            type: "string",
            description: "user language ar or en"
        ),

        new OA\Property(
            property: "enable_notification",
            type: "number",
            description: "enable notification 0 : off , 1:on"
        ),

        new OA\Property(
            property: "schedule_notification_before",
            type: "number",
            description: "schedule_notification_before"
        ),
        new OA\Property(
            property: "role",
            type: "string",
            example: "patient",
            description: "User role."
        ),

        new OA\Property(
            property: "register_step",
            type: "string",
            example: "finish",
            description: "Current registration step."
        ),

        new OA\Property(
            property: "is_register_end",
            type: "integer",
            enum: [0, 1],
            example: 1,
            description: "Whether registration has been completed."
        ),

    ],

    example: [
        "user" => [
            "id" => "1",
            "name" => "test",
            "email" => "",
            "mobile" => "0592105087",
            "status" => "enabled",
            "avatar" => "http://localhost:8000/uploads/blank.png",
            "accessToken" => "1|9Y7tGIqrsOuvISbXJV67IsMZauA26kE1KoTU04H5",
            "language" => "ar",
            "activation_code" => "1234",
            "enable_notification" => 0,
            "schedule_notification_before" => 0,
            "role" => "patient",
            "register_step" => "finish",
            "is_register_end" => 1,
        ]
    ]
)]

class UserResource extends JsonResource
{

    public function toArray($request)
    {
        $user =  [
            'id' => (int) $this->id,
            'name' => (string) $this->name,
            'email' => (string) $this->email,
            'mobile' => (string) $this->mobile,
            'status' => (string) $this->status,
            'avatar' => (string) $this->image_url,
            'accessToken' => (string) $this->accessToken,
            'language' => (string) $this->language,
            'activation_code' => (string) $this->activation_code,
            'enable_notification' => (int) $this->enable_notification,
//            'schedule_notification_before' => (int) $this->schedule_notification_before,
            'created_at' => $this->created_at->toDateString(),
            'role' => $this->role,
            'register_step' => $this->register_step,
            'is_register_end' => $this->is_register_end,
        ];

        if($this->role == 'patient' && $this->patient){
            $user['patient'] = [
                'id' => (int) $this->patient->id,
                'user_id' => (int) $this->patient->user_id,
                'national_id' =>$this->patient?->national_id,
                'current_job' =>$this->patient?->current_job,
                'address' =>$this->patient?->address,
                'birth_date' => $this->patient->date_of_birth?->toDateString(),
                'gender' => $this->patient->gender,
                'blood_type' => $this->patient->blood_type,

                'dialysis_start_date' => $this->patient->dialysis_start_date?->toDateString(),
                'dialysis_type' => $this->patient->dialysis_type,
                'sessions_per_week' => $this->patient->sessions_per_week,
                'daily_fluid_limit' => $this->patient->daily_fluid_limit,

                'dialysis_center_id' => $this->patient->dialysis_center_id,
                'dialysis_center' => $this->patient->centers,
                'dialysis_centers' => $this->patient->centers?? [],
                'doctors' => DoctorResource::collection($this->patient->doctors) ?? [],
            ];
        }
        if($this->role == 'family'){

            $user['family_member'] = $this->when(
                $this->familyMember,
                function () {
                    return [
                        'id' => $this->familyMember->id,
                        'relationships' => $this->familyMember
                            ->patientFamilyMembers
                            ->map(function ($relation) {
                                return [
                                    'patient_id' => $relation->patient_id,
                                    'relationship' => $relation->relationship,
                                    'status' => $relation->status,
                                ];
                            })
                            ->values(),
                    ];
                }
            );
        }

        return $user;
    }
}
