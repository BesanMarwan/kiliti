<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\PatientSymptomRequest;
use App\Http\Resources\User\PatientSymptomResource;
use App\Http\Resources\User\SymptomResource;
use App\Models\PatientSymptom;
use App\Models\Symptom;
use App\Actions\ApiActions;
use App\Services\SymptomAlertService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Patient Symptoms",
    description: "Patient symptoms management"
)]
class PatientSymptomController extends Controller
{
    public function __construct(public SymptomAlertService $symptomAlertService){

    }
    #[OA\Get(
        path: "/api/v1/user/symptoms",
        summary: "Get available symptoms",
        security: [["api_key" => []]],
        tags: ["Patient Symptoms"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Symptoms retrieved successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                ref: "#/components/schemas/SymptomResource"
                            )
                        )
                    ]
                )
            )
        ]
    )]
    public function index()
    {
        $symptoms = Symptom::query()->active()->orderBy('name')->get();
        return ApiActions::generateResponse(SymptomResource::collection($symptoms));
    }


    #[OA\Post(
        path: "/api/v1/user/symptoms",
        summary: "Record a patient symptom",
        security: [["api_key" => []]],
        tags: ["Patient Symptoms"],

        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: [
                    "symptom_id",
                    "severity",
                    "recorded_at"
                ],
                properties: [
                    new OA\Property(
                        property: "symptom_id",
                        type: "integer",
                        example: 1
                    ),

                    new OA\Property(
                        property: "severity",
                        type: "integer",
                        minimum: 1,
                        maximum: 5,
                        example: 4
                    ),

//                    new OA\Property(
//                        property: "recorded_at",
//                        type: "string",
//                        format: "date-time",
//                        example: "2026-09-28 13:30:00"
//                    ),

                    new OA\Property(
                        property: "notes",
                        type: "string",
                        nullable: true,
                        example: "Feeling shortness of breath after dialysis."
                    ),
                ]
            )
        ),

        responses: [
            new OA\Response(
                response: 201,
                description: "Symptom recorded successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/PatientSymptomResource"
                        )
                    ]
                )
            ),

            new OA\Response(
                response: 422,
                description: "Validation error"
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            )
        ]
    )]
    public function store(PatientSymptomRequest $request)
    {
        $patient = $request->user()->patient;

        abort_unless($patient, 404, 'Patient profile not found.');

        $symptom = Symptom::query()->where('id', $request->symptom_id)->active()->firstOrFail();

        $patientSymptom = PatientSymptom::create([
            'patient_id' => $patient->id,
            'symptom_id' => $symptom->id,
            'severity' => $request->severity,
            'recorded_at' => $request->recorded_at ?? now(),
            'notes' => $request->notes,
        ]);

        $patientSymptom->load('symptom');

        /*
         * Critical alert logic can be triggered here.
         *
         * Example:
         *
         * if ($symptom->is_critical && $request->severity >= 4) {
         *     // Send alert to doctor/family
         * }
         */
        $result = $this->symptomAlertService->handle($patientSymptom);
        if ($result['should_notify_doctor']) {
            // send notification (event & listener)
        }
        if ($result['should_notify_doctor']) {
            // send notification
        }

        return $result;
        return ApiActions::generateResponse(PatientSymptomResource::make($patientSymptom),);
    }


    #[OA\Get(
        path: "/api/v1/user/symptoms/history",
        summary: "Get patient symptoms history",
        security: [["api_key" => []]],
        tags: ["Patient Symptoms"],

        parameters: [
            new OA\Parameter(
                name: "from",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    format: "date"
                ),
                example: "2026-09-01"
            ),

            new OA\Parameter(
                name: "to",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    format: "date"
                ),
                example: "2026-09-28"
            ),

            new OA\Parameter(
                name: "symptom_id",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "integer"
                ),
                example: 1
            ),

            new OA\Parameter(
                name: "severity",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "integer",
                    minimum: 1,
                    maximum: 5
                ),
                example: 4
            ),
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Symptoms history retrieved successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                ref: "#/components/schemas/PatientSymptomResource"
                            )
                        )
                    ]
                )
            )
        ]
    )]
    public function history(Request $request)
    {
        $patient = $request->user()->patient;

        abort_unless($patient, 404, 'Patient profile not found.');

        $query = PatientSymptom::query()
                            ->where('patient_id', $patient->id)
                            ->with('symptom')
                            ->latest('recorded_at');

        if ($request->filled('from')) {
            $query->whereDate('recorded_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('recorded_at', '<=', $request->to);
        }

        if ($request->filled('symptom_id')) {
            $query->where('symptom_id', $request->symptom_id);
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        $symptoms = $query->get();

        return ApiActions::generateResponse(PatientSymptomResource::collection($symptoms));
    }


    #[OA\Get(
        path: "/api/v1/user/symptoms/{patientSymptom}",
        summary: "Get patient symptom details",
        security: [["api_key" => []]],
        tags: ["Patient Symptoms"],

        parameters: [
            new OA\Parameter(
                name: "patientSymptom",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer"
                ),
                example: 1
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Symptom details retrieved successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/PatientSymptomResource"
                        )
                    ]
                )
            ),

            new OA\Response(
                response: 404,
                description: "Symptom record not found"
            )
        ]
    )]
    public function show(Request $request, PatientSymptom $patientSymptom)
    {
        $patient = $request->user()->patient;

        abort_unless($patient, 404, 'Patient profile not found.');

        abort_unless($patientSymptom->patient_id === $patient->id, 403, 'Unauthorized.');

        $patientSymptom->load('symptom');

        return ApiActions::generateResponse(PatientSymptomResource::make($patientSymptom));
    }
}
