<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\ApiActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\DoctorConsultationRequest;
use App\Http\Resources\User\DoctorConsultationResource;
use App\Models\Doctor;
use App\Models\DoctorConsultation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Doctor Consultations",
    description: "Patient communication with doctors"
)]
class DoctorConsultationController extends Controller
{

    #[OA\Post(
        path: "/api/v1/user/doctor-consultations",
        summary: "Send consultation to doctor",
        security: [["api_key" => []]],
        tags: ["Doctor Consultations"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["doctor_id", "type", "message"],
            properties: [
                new OA\Property(
                    property: "doctor_id",
                    type: "integer",
                    example: 3
                ),

                new OA\Property(
                    property: "consultation_type",
                    type: "number",
                    description: "consultation type id ",
                ),

                new OA\Property(
                    property: "message",
                    type: "string",
                    example: "هل يمكنني أخذ الدواء قبل جلسة الغسيل؟"
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Consultation sent"
    )]
    public function store(DoctorConsultationRequest $request) {
        $patient = $request->user()->patient;

        $doctor = Doctor::query()
                      ->where('id', $request->doctor_id)
                      ->whereHas('user', function ($query) {
                          $query->where('status', 'enabled');
                      })->with('patients')
                      ->whereHas('patients',function($query) use($patient){
                          $query->where('user_id',auth()->user()->id);
                      })
                      ->first();




        abort_unless($doctor, 404);

        $consultation = DoctorConsultation::create([
            'patient_id'        => $patient->id,
            'doctor_id'         => $doctor->id,
            'consultation_type' => $request->consultation_type,
            'message'           => $request->message,
            'status'            => 'pending',
            'sent_at'           => now('Asia/Gaza'),
        ]);

        $consultation->load(['doctor.user']);
         return ApiActions::generateResponse(DoctorConsultationResource::make($consultation),'consultation_send_success');
    }


    #[OA\Get(
        path: "/api/v1/user/doctor-consultations",
        summary: "Get patient's consultations",
        security: [["api_key" => []]],
        tags: ["Doctor Consultations"]
    )]
    #[OA\Parameter(
        name: "status",
        description: "Consultation Status",
        in: "query",
        required: false,
        schema: new OA\Schema(
            type: "string",
            enum: [
                "pending",
                "answered",
                "closed",
            ],

        )
    )]

    #[OA\Response(
        response: 200,
        description: "Consultations history"
    )]
    public function index(Request $request): JsonResponse
    {
        $patient = $request->user()->patient;

        abort_unless($patient, 403);

        $consultations = DoctorConsultation::query()
                              ->filter($request)
                               ->where('patient_id', $patient->id)
                               ->with('doctor.user')
                               ->latest('sent_at')
                               ->get();

        return ApiActions::generateResponse(DoctorConsultationResource::collection($consultations));
    }


//    #[OA\Get(
//        path: "/api/v1/user/doctor-consultations/{consultation}",
//        summary: "Get consultation details",
//        security: [["api_key" => []]],
//        tags: ["Doctor Consultations"]
//    )]
//    #[OA\Parameter(
//        name: "consultation",
//        description: "Consultation ID",
//        in: "path",
//        required: true,
//        schema: new OA\Schema(type: "integer", example: 1)
//    )]
//    #[OA\Response(
//        response: 200,
//        description: "Consultation details"
//    )]
//    public function show(Request $request, DoctorConsultation $consultation) {
//
//        $patient = $request->user()->patient;
//        abort_unless($patient && $consultation->patient_id === $patient->id, 403);
//
//        $consultation->load('doctor.user');
//
//        return ApiActions::generateResponse(new DoctorConsultationResource($consultation));
//    }
}
