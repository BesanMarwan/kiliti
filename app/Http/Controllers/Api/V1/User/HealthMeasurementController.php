<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\ApiActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\DateRangeRequest;
use App\Http\Requests\Api\User\HealthMeasurementRequest;
use App\Http\Resources\User\HealthMeasurementResource;
use App\Http\Resources\User\HealthMeasurementSummaryResource;
use App\Models\HealthMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use OpenApi\Attributes as OA;

class HealthMeasurementController extends Controller
{
    #[OA\Post(
        path: "/api/v1/user/health-measurements",
        summary: "Store health measurement",
        description: "Store a new health measurement for the authenticated patient.",
        security: [["api_key" => []]],
        tags: ["Health Measurements"],

        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: "#/components/schemas/HealthMeasurementRequest"
            )
        ),

        responses: [
            new OA\Response(
                response: 201,
                description: "Health measurement created successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "success",
                            type: "boolean",
                            example: true
                        ),

                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Health measurement created successfully."
                        ),

                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/HealthMeasurementResource"
                        ),
                    ]
                )
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),

            new OA\Response(
                response: 404,
                description: "Patient profile not found"
            ),

            new OA\Response(
                response: 422,
                description: "Validation error"
            ),
        ]
    )]
    public function store(HealthMeasurementRequest $request)
    {
        $patient = $request->user()->patient;

        abort_unless($patient, 404, 'Patient profile not found.');

        $data = $request->validated();

        $units = [
            'weight' => 'kg',
            'blood_pressure' => 'mmHg',
            'heart_rate' => 'bpm',
            'temperature' => '°C',
            'blood_sugar' => 'mg/dL',
        ];

        $data['unit'] = $units[$data['type']];

        $measurement = HealthMeasurement::create([
            'patient_id' => $patient->id,
            'type' => $data['type'],
            'value' => $data['value'],
            'value_secondary' => $data['value_secondary'] ?? null,
            'unit' => $data['unit'],
            'measured_at' => $data['measured_at'],
            'notes' => $data['notes'] ?? null,
        ]);

        return ApiActions::generateResponse(new HealthMeasurementResource($measurement), 'Health_measurement_created_successfully.');
    }

    /**
     * Get health measurements history.
     */
    #[OA\Get(
        path: "/api/v1/user/health-measurements",
        summary: "Get health measurements",
        description: "Get health measurements history for the authenticated patient.",
        security: [["api_key" => []]],
        tags: ["Health Measurements"],
        parameters: [
            new OA\Parameter(
                name: "type",
                description: "Measurement type",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    enum: [
                        "weight",
                        "blood_pressure",
                        "heart_rate",
                        "temperature",
                        "blood_sugar"
                    ],
                )
            ),
            new OA\Parameter(
                name: "measured_at_from",
                description: "Start date",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    format: "date",
                )
            ),
            new OA\Parameter(
                name: "measured_at_to",
                description: "End date",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    format: "date",
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Health measurements retrieved successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "success",
                            type: "boolean",
                            example: true
                        ),
                        new OA\Property(
                            property: "message",
                            type: "string",
                            nullable: true,
                            example: null
                        ),
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                ref: "#/components/schemas/HealthMeasurementResource"
                            )
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            )
        ]
    )]
    public function index(Request $request)
    {
        $patient = $request->user()->patient;

        abort_unless($patient, 404, 'Patient profile not found.');

        $measurements = HealthMeasurement::query()->filter($request)->where('patient_id', $patient->id)->orderByDesc('measured_at')->get();

        return ApiActions::generateResponse(HealthMeasurementResource::collection($measurements));
    }
//
    /**
     * Get latest health measurements summary.
     */
    #[OA\Get(
        path: "/api/v1/user/health-measurements/summary",
        summary: "Get health measurements summary for dashboard",
        description: "Get the latest weight, blood pressure and heart rate measurements.",
        security: [["api_key" => []]],
        tags: ["Health Measurements"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Summary retrieved successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "success",
                            type: "boolean",
                            example: true
                        ),
                        new OA\Property(
                            property: "message",
                            type: "string",
                            nullable: true,
                            example: null
                        ),
                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/HealthMeasurementSummaryResource"
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),
            new OA\Response(
                response: 404,
                description: "Patient profile not found"
            )
        ]
    )]
    public function summary(Request $request)
    {
        $patient = $request->user()->patient;

        abort_unless($patient, 404, 'Patient profile not found.');

        $latestWeight = HealthMeasurement::query()
                                       ->where('patient_id', $patient->id)
                                       ->where('type', 'weight')
                                       ->latest('measured_at')
                                       ->first();

        $latestBloodPressure = HealthMeasurement::query()
                                           ->where('patient_id', $patient->id)
                                           ->where('type', 'blood_pressure')
                                           ->latest('measured_at')
                                           ->first();

        $latestHeartRate = HealthMeasurement::query()
                                          ->where('patient_id', $patient->id)
                                          ->where('type', 'heart_rate')
                                          ->latest('measured_at')
                                          ->first();

        $data['weight']         = $latestWeight;
        $data['blood_pressure'] = $latestBloodPressure;
        $data['heart_rate']     = $latestHeartRate;

        return ApiActions::generateResponse(new HealthMeasurementSummaryResource($data));
    }
}
