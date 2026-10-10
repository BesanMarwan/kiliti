<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\ApiActions;
use App\Constants\ResponseCode;
use App\Http\Controllers\Controller;

use App\Http\Requests\Api\User\PatientMedicationScheduleRequest;
use App\Http\Resources\User\MedicationLogResource;
use App\Http\Resources\User\PatientMedicationScheduleResource;
use App\Http\Resources\User\PatientMedicationScheduleResponseResource;
use App\Http\Resources\User\PatientMedicineDetailsResource;
use App\Http\Resources\User\PatientMedicineResource;
use App\Models\MedicationLog;
use App\Models\PatientMedication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "PatientMedicationsApiSection",
    description: "API Package for Medications requests"
)]
class PatientMedicationController extends Controller
{

    #[OA\Get(
        path: "/api/v1/user/my_medicine",
        operationId: "GetPatientMedications",
        tags: ["PatientMedicationsApiSection"],
        summary: "Get Patient Medicines logs API",
        description: "Get Patient Medicines service",
        security: [["api_key" => []]],
        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "successful operation with status = true and notifications array of objects"
            )
        ]
    )]
    public function myMedicine(Request $request)
    {
        $patientId = \auth()->user()->patient->id;

        $medications = PatientMedication::with('doctor')
                                   ->where('patient_id', $patientId)
                                   ->get();

        $activeMedications         = $medications->where('status', 'active');
        $data['totalActiveCount']  = $activeMedications->count();
//        $data['totalDailyDoses']   = $activeMedications->sum('frequency');

//        $data['nextDose']    = PatientMedicineResource::make($activeMedications->sortBy('next_dose_time')->first());
        $data['medications'] = PatientMedicineResource::collection($medications);
        return ApiActions::generateResponse($data);
    }


    #[OA\Get(
        path: "/api/v1/user/medications/schedule",
        operationId: "getPatientMedicationSchedule",
        tags: ["PatientMedicationsApiSection"],
        summary: "Get Patient Medication Schedule",
        description: "Get patient's medication schedule for a specific date.",
        security: [["api_key" => []]],

        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            ),

            new OA\Parameter(
                name: "date",
                in: "query",
                required: false,
                description: "Schedule date. Defaults to today.",
                schema: new OA\Schema(
                    type: "string",
                    format: "date",
                    example: "2026-09-26"
                )
            ),

            new OA\Parameter(
                name: "period",
                in: "query",
                required: false,
                description: "Filter medications by time period.",
                schema: new OA\Schema(
                    type: "string",
                    enum: [
                        "all",
                        "morning",
                        "afternoon",
                        "evening"
                    ],
                    default: "all"
                )
            ),
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Medication schedule retrieved successfully.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "status",
                            type: "boolean",
                            example: true
                        ),

                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/PatientMedicationScheduleResponseResource"
                        ),
                    ]
                )
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated."
            ),

            new OA\Response(
                response: 404,
                description: "Patient profile not found."
            ),

            new OA\Response(
                response: 422,
                description: "Validation error."
            ),
        ]
    )]
    public function schedule(PatientMedicationScheduleRequest $request)
    {
        $patient = $request->user()->patient;

        if (!$patient) {
            return ApiActions::generateResponse(
                null,
                'patient_profile_not_found.',
                ResponseCode::NOT_FOUND
            );
        }

        $timezone = 'Asia/Gaza';

        /*
        |--------------------------------------------------------------------------
        | Requested local date
        |--------------------------------------------------------------------------
        */

        $date = $request->filled('date')
            ? Carbon::createFromFormat(
                'Y-m-d',
                $request->input('date'),
                $timezone
            )->startOfDay()
            : now($timezone)->startOfDay();

        $period = $request->input('period', 'all');

        /*
        |--------------------------------------------------------------------------
        | Local day boundaries -> UTC
        |--------------------------------------------------------------------------
        */

        $startUtc = $date
            ->copy()
            ->startOfDay()
            ->utc();

        $endUtc = $date
            ->copy()
            ->endOfDay()
            ->utc();

        /*
        |--------------------------------------------------------------------------
        | Get all logs for the patient's local day
        |--------------------------------------------------------------------------
        */

        $dailyLogs = MedicationLog::query()
            ->whereBetween('scheduled_at', [
                $startUtc,
                $endUtc,
            ])
            ->whereHas('patientMedication', function ($query) use ($patient) {
                $query->where('patient_id', $patient->id);
            })
            ->with([
                'patientMedication.medication',
                'patientMedication.routeObj',
            ])
            ->orderBy('scheduled_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Has medications
        |--------------------------------------------------------------------------
        */

        $hasMedications = PatientMedication::query()
            ->where('patient_id', $patient->id)
            ->exists();

        /*
        |--------------------------------------------------------------------------
        | Daily adherence
        |--------------------------------------------------------------------------
        */

        $totalDoses = $dailyLogs->count();

        $takenDoses = $dailyLogs
            ->where('status', 'taken')
            ->count();

        $adherence = $totalDoses > 0
            ? round(($takenDoses / $totalDoses) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Overdue
        |--------------------------------------------------------------------------
        */

        $now = now($timezone);

        $overdueCount = $dailyLogs
            ->filter(function ($log) use ($now,$timezone) {
                $scheduledAt = $log->scheduled_at->copy()->setTimezone($timezone);

                return $scheduledAt->lt($now)
                    && in_array($log->status, [
                        'pending',
                        'notified',
                        'snoozed',
                    ], true);
            })
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Filter period
        |--------------------------------------------------------------------------
        */

        $logs = $dailyLogs
            ->filter(function ($log) use ($period, $timezone) {

                if ($period === 'all') {
                    return true;
                }

                $scheduledAt = $log->scheduled_at
                    ->copy()
                    ->setTimezone($timezone);

                $hour = $scheduledAt->hour;

                return match ($period) {
                    'morning' => $hour >= 5 && $hour < 12,
                    'afternoon' => $hour >= 12 && $hour < 17,
                    'evening' => $hour >= 17 && $hour < 24,
                    default => false,
                };
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Current / Next dose
        |--------------------------------------------------------------------------
        */

        $currentLogId = null;
        $nextLogId = null;

        foreach ($dailyLogs as $log) {

            $scheduledAt = $log->scheduled_at
                ->copy()
                ->setTimezone($timezone);

            if (
                !$currentLogId &&
                $scheduledAt->lte($now) &&
                in_array($log->status, [
                    'pending',
                    'notified',
                    'snoozed',
                ], true)
            ) {
                $currentLogId = $log->id;
            }

            if (
                !$nextLogId &&
                $scheduledAt->gt($now) &&
                in_array($log->status, [
                    'pending',
                    'notified',
                    'snoozed',
                ], true)
            ) {
                $nextLogId = $log->id;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        $logs->each(function ($log) use ($currentLogId, $nextLogId) {
            $log->is_current = $log->id === $currentLogId;
            $log->is_next = $log->id === $nextLogId;
        });

        $data = [
            'date' => $date->toDateString(),

            'timezone' => $timezone,

            'period' => $period,

            'has_medications' => $hasMedications,

            'overdue_count' => $overdueCount,

            'adherence' => [
                'total' => $totalDoses,
                'taken' => $takenDoses,
                'percentage' => $adherence,
            ],

            'current_log_id' => $currentLogId,

            'next_log_id' => $nextLogId,

            'medications' => PatientMedicationScheduleResource::collection(
                $logs
            ),
        ];

        return ApiActions::generateResponse(compact('data'));
    }


    #[OA\Get(
        path: "/api/v1/user/medicine_details",
        operationId: "medicineDetails",
        tags: ["PatientMedicationsApiSection"],
        summary: "get Patient Medicine Details",
        description: "me",
        security: [["api_key" => []]],
        parameters: [
            new OA\Parameter(
                name: "patientMedication",
                description: "Patient medication ID.",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer",
                    example: 7699
                )
            ),

            new OA\Parameter(
                ref: "#/components/parameters/language"
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Patient medication details retrieved successfully.",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "status",
                            type: "boolean",
                            example: true
                        ),

                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "medicine",
                                    ref: "#/components/schemas/PatientMedicineDetails"
                                ),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Unauthenticated.",
                content: new OA\JsonContent(
                    example: [
                        "status" => false,
                        "message" => "Unauthenticated."
                    ]
                )
            ),

            new OA\Response(
                response: 404,
                description: "Patient medication not found.",
                content: new OA\JsonContent(
                    example: [
                        "status" => false,
                        "message" => "Patient medication not found."
                    ]
                )
            ),

        ]
    )]
    public function medicineDetails(PatientMedication $patientMedication){

        $patient = auth()->user()->patient;

        abort_unless($patient && $patientMedication->patient_id === $patient->id, 404);

        $patientMedicine = PatientMedicineDetailsResource::make($patientMedication);

        $patientMedication->load([
            'medication',
            'doctor.user',
            'medicationLogs' => function ($query) {
                $query->whereDate('scheduled_at', now('Asia/Gaza')->toDateString())->orderBy('scheduled_at');
            },
        ]);

        return ApiActions::generateResponse([
            'medicine' => new PatientMedicineDetailsResource($patientMedication),
        ]);

    }



    #[OA\Post(
        path: "/api/v1/user/medications/logs/{medicationLog}/taken",
        operationId: "markMedicationLogTaken",
        tags: ["PatientMedicationsApiSection"],

        summary: "Mark medication dose as taken",

        description: "Mark a scheduled medication dose as taken for the authenticated patient. The response includes the updated medication log and the patient's medication adherence summary.",

        security: [["api_key" => []]],

        parameters: [
            new OA\Parameter(
                name: "medicationLog",
                description: "Medication log ID belonging to the authenticated patient.",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer",
                    example: 101
                )
            ),

            new OA\Parameter(
                ref: "#/components/parameters/language"
            ),
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Medication dose marked as taken successfully.",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "status",
                            type: "boolean",
                            example: true
                        ),

                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "medication_log",
                                    ref: "#/components/schemas/MedicationLog"
                                ),

                                new OA\Property(
                                    property: "adherence",
                                    type: "object",
                                    properties: [
                                        new OA\Property(
                                            property: "total",
                                            type: "integer",
                                            example: 5
                                        ),

                                        new OA\Property(
                                            property: "taken",
                                            type: "integer",
                                            example: 4
                                        ),

                                        new OA\Property(
                                            property: "percentage",
                                            type: "number",
                                            format: "float",
                                            example: 80
                                        ),
                                    ]
                                ),
                            ]
                        ),
                    ]
                )
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated.",
                content: new OA\JsonContent(
                    example: [
                        "status" => false,
                        "message" => "Unauthenticated."
                    ]
                )
            ),

            new OA\Response(
                response: 403,
                description: "Medication log does not belong to the authenticated patient.",
                content: new OA\JsonContent(
                    example: [
                        "status" => false,
                        "message" => "Unauthorized."
                    ]
                )
            ),

            new OA\Response(
                response: 404,
                description: "Medication log not found.",
                content: new OA\JsonContent(
                    example: [
                        "status" => false,
                        "message" => "Medication log not found."
                    ]
                )
            ),

            new OA\Response(
                response: 409,
                description: "Medication dose cannot be marked as taken in its current state.",
            ),

            new OA\Response(
                response: 422,
                description: "Medication dose cannot be taken yet.",
                content: new OA\JsonContent(
                    example: [
                        "status" => false,
                        "message" => "Medication dose is scheduled for a future time."
                    ]
                )
            ),
        ]
    )]
    public function markTaken(MedicationLog $medicationLog)
    {
        $this->authorizeLog($medicationLog);

        $now = now('Asia/Gaza');


        if ($medicationLog->status === 'taken') {
             return ApiActions::generateResponse(null, 'Medication_is_already_marked_as_taken.', ResponseCode::VALIDATION_ERROR);
        }
        if ($medicationLog->status === 'missed') {
            return ApiActions::generateResponse(null, 'Medication_is_already_missed.', ResponseCode::VALIDATION_ERROR);
        }

        $medicationLog->update([
            'status' => 'taken',
            'taken_at' => now(),
            'snoozed_until' => null,
        ]);
        $patientId = $medicationLog->patientMedication->patient_id;

        $today = $now->toDateString();

        $todayLogs = MedicationLog::query()
            ->whereDate('scheduled_at', $today)
            ->whereHas('patientMedication', function ($query) use ($patientId) {
                $query->where('patient_id', $patientId);
            })
            ->get();

        $total = $todayLogs->count();

        $taken = $todayLogs
            ->where('status', 'taken')
            ->count();

        $percentage = $total > 0
            ? round(($taken / $total) * 100)
            : 0;

        return ApiActions::generateResponse([
            'medication_log' => new MedicationLogResource($medicationLog),

            'adherence' => [
                'total' => $total,
                'taken' => $taken,
                'percentage' => $percentage,
            ],
        ]);

    }




    #[OA\Post(
        path: "/api/v1/user/medications/log/{medicationLog}/snooze",
        operationId: "snoozeMedicationLog",
        tags: ["PatientMedicationsApiSection"],

        summary: "Snooze a medication dose",

        description: "Snooze a scheduled medication dose for a predefined number of minutes. Allowed values are 5, 10, 15, 30, or 60 minutes. The response contains the updated medication log including the new snoozed_until time.",

        security: [["api_key" => []]],

        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["minutes"],
                properties: [
                    new OA\Property(
                        property: "minutes",
                        description: "Number of minutes to snooze the medication dose.",
                        type: "integer",
                        enum: [5, 10, 15, 30, 60],
                        example: 15
                    ),
                ]
            )
        ),

        parameters: [
            new OA\Parameter(
                name: "medicationLog",
                description: "Medication log ID belonging to the authenticated patient.",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer",
                    example: 101
                )
            ),

            new OA\Parameter(
                ref: "#/components/parameters/language"
            ),
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Medication dose snoozed successfully.",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "status",
                            type: "boolean",
                            example: true
                        ),

                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "medication_log",
                                    ref: "#/components/schemas/MedicationLog"
                                ),

                                new OA\Property(
                                    property: "snoozed_until",
                                    type: "string",
                                    format: "date-time",
                                    example: "2026-10-07T12:15:00+03:00"
                                ),
                            ]
                        ),
                    ]
                )
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated.",
                content: new OA\JsonContent(
                    example: [
                        "status" => false,
                        "message" => "Unauthenticated."
                    ]
                )
            ),

            new OA\Response(
                response: 403,
                description: "Medication log does not belong to the authenticated patient.",
                content: new OA\JsonContent(
                    example: [
                        "status" => false,
                        "message" => "Unauthorized."
                    ]
                )
            ),

            new OA\Response(
                response: 404,
                description: "Medication log not found.",
                content: new OA\JsonContent(
                    example: [
                        "status" => false,
                        "message" => "Medication log not found."
                    ]
                )
            ),

            new OA\Response(
                response: 409,
                description: "Medication dose cannot be snoozed in its current state.",
                content: new OA\JsonContent(
                    example: [
                        "status" => false,
                        "message" => "Medication dose cannot be snoozed in its current state."
                    ]
                )
            ),

            new OA\Response(
                response: 422,
                description: "Invalid snooze duration.",
                content: new OA\JsonContent(
                    example: [
                        "status" => false,
                        "message" => "The selected minutes are invalid."
                    ]
                )
            ),
        ]
    )]
    public function snooze(Request $request, MedicationLog $medicationLog)
    {
        $this->authorizeLog($medicationLog);

        $request->validate(['minutes' => ['required', 'integer', 'in:5,10,15,30,60']]);

        if ($medicationLog->status === 'missed') {
            return ApiActions::generateResponse(null, 'Medication_is_already_missed.', ResponseCode::VALIDATION_ERROR);
        }

        if ($medicationLog->status === 'taken') {
            return ApiActions::generateResponse(null, 'Medication_is_already_marked_as_taken.', ResponseCode::VALIDATION_ERROR);
        }

        $snoozedUntil = now('Asia/Gaza')->addMinutes($request->integer('minutes'));

        $medicationLog->update([
            'status' => 'snoozed',
            'snoozed_until' => $snoozedUntil,
        ]);

        $medicationLog->load(['patientMedication.medication', 'patientMedication.routeObj',]);

        return ApiActions::generateResponse([
            'medication_log' => new MedicationLogResource($medicationLog),
            'snoozed_until' => $medicationLog->snoozed_until?->toISOString(),
        ]);
    }




//
//    #[OA\Get(
//        path: "/api/v1/user/medicines/adherence",
//        operationId: "adherence",
//        tags: ["PatientMedicationsApiSection"],
//        summary: "Get Patient adherence logs API",
//        description: "Get Patient adherence service",
//        security: [["api_key" => []]],
//        parameters: [
//            new OA\Parameter(
//                ref: "#/components/parameters/language"
//            )
//        ],
//        responses: [
//            new OA\Response(
//                response: 200,
//                description: "successful operation with status = true and notifications array of objects"
//            )
//        ]
//    )]
//    public function adherence()
//    {
//        $patientId       = \auth()->user()->patient->id;
//
//        $patientMedicine = PatientMedication::where('patient_id',$patientId)->pluck('id')->toArray();
//
//        $data['totalSent']       = MedicationLog::whereIn('patient_medication_id',$patientMedicine )->whereMonth('scheduled_at', now()->month)->count();
//        $data['totalTaken']      = MedicationLog::whereIn('patient_medication_id', $patientMedicine)->where('status', 'taken')->whereMonth('scheduled_at', now()->month)->count();
//        $data['rate']            =  $data['totalSent'] > 0 ? round(( $data['totalTaken'] /  $data['totalSent']) * 100) : 0;
//
//        return ApiActions::generateResponse($data);
//
//    }

//    public function adherence(Request $request)
//    {
//        $patient = $request->user()->patient;
//
//        if (!$patient) {
//            return ApiActions::generateResponse(
//                null,
//                'patient_profile_not_found.',
//                ResponseCode::NOT_FOUND
//            );
//        }
//
//        $request->validate([
//            'month' => ['nullable', 'integer', 'between:1,12'],
//            'year' => ['nullable', 'integer', 'min:2020', 'max:2100'],
//        ]);
//
//        $timezone = 'Asia/Gaza';
//
//        $now = now($timezone);
//
//        $month = (int) $request->input('month', $now->month);
//        $year  = (int) $request->input('year', $now->year);
//
//        /*
//        |--------------------------------------------------------------------------
//        | Patient medications
//        |--------------------------------------------------------------------------
//        */
//
//        $patientMedicationIds = PatientMedication::query()
//            ->where('patient_id', $patient->id)
//            ->pluck('id');
//
//        /*
//        |--------------------------------------------------------------------------
//        | Medication logs for selected month
//        |--------------------------------------------------------------------------
//        */
//
//        $logs = MedicationLog::query()
//            ->whereIn('patient_medication_id', $patientMedicationIds)
//            ->whereYear('scheduled_at', $year)
//            ->whereMonth('scheduled_at', $month)
//            ->get();
//
//        /*
//        |--------------------------------------------------------------------------
//        | Overall statistics
//        |--------------------------------------------------------------------------
//        */
//
//        $totalScheduled = $logs->count();
//
//        $totalTaken = $logs
//            ->where('status', 'taken')
//            ->count();
//
//        $totalMissed = $logs
//            ->where('status', 'missed')
//            ->count();
//
//        $totalPending = $logs
//            ->where('status', 'pending')
//            ->count();
//
//        $totalSnoozed = $logs
//            ->where('status', 'snoozed')
//            ->count();
//
//        $totalSkipped = $logs
//            ->where('status', 'skipped')
//            ->count();
//
//        /*
//        |--------------------------------------------------------------------------
//        | Overall adherence rate
//        |--------------------------------------------------------------------------
//        */
//
//        $rate = $totalScheduled > 0
//            ? round(($totalTaken / $totalScheduled) * 100)
//            : 0;
//
//        /*
//        |--------------------------------------------------------------------------
//        | Daily adherence
//        |--------------------------------------------------------------------------
//        */
//
//        $dailyAdherence = $logs
//            ->groupBy(function ($log) use ($timezone) {
//                return $log->scheduled_at
//                    ->setTimezone($timezone)
//                    ->format('Y-m-d');
//            })
//            ->map(function ($dayLogs, $date) {
//
//                $total = $dayLogs->count();
//
//                $taken = $dayLogs
//                    ->where('status', 'taken')
//                    ->count();
//
//                $missed = $dayLogs
//                    ->where('status', 'missed')
//                    ->count();
//
//                $pending = $dayLogs
//                    ->where('status', 'pending')
//                    ->count();
//
//                $snoozed = $dayLogs
//                    ->where('status', 'snoozed')
//                    ->count();
//
//                $skipped = $dayLogs
//                    ->where('status', 'skipped')
//                    ->count();
//
//                $rate = $total > 0
//                    ? round(($taken / $total) * 100)
//                    : 0;
//
//                return [
//                    'date' => $date,
//                    'total' => $total,
//                    'taken' => $taken,
//                    'missed' => $missed,
//                    'pending' => $pending,
//                    'snoozed' => $snoozed,
//                    'skipped' => $skipped,
//                    'rate' => $rate,
//                ];
//            })
//            ->sortKeys()
//            ->values();
//
//        /*
//        |--------------------------------------------------------------------------
//        | Calendar days
//        |--------------------------------------------------------------------------
//        |
//        | Include days that have no medication logs.
//        |
//        */
//
//        $startOfMonth = Carbon::create(
//            $year,
//            $month,
//            1,
//            0,
//            0,
//            0,
//            $timezone
//        );
//
//        $endOfMonth = $startOfMonth->copy()->endOfMonth();
//
//        $calendar = collect();
//
//        $currentDate = $startOfMonth->copy();
//
//        while ($currentDate->lte($endOfMonth)) {
//
//            $date = $currentDate->format('Y-m-d');
//
//            $day = $dailyAdherence->firstWhere('date', $date);
//
//            $calendar->push(
//                $day ?? [
//                'date' => $date,
//                'total' => 0,
//                'taken' => 0,
//                'missed' => 0,
//                'pending' => 0,
//                'snoozed' => 0,
//                'skipped' => 0,
//                'rate' => 0,
//            ]
//            );
//
//            $currentDate->addDay();
//        }
//
//        /*
//        |--------------------------------------------------------------------------
//        | Response
//        |--------------------------------------------------------------------------
//        */
//
//        $data = [
//
//            'period' => [
//                'month' => $month,
//                'year' => $year,
//                'start_date' => $startOfMonth->toDateString(),
//                'end_date' => $endOfMonth->toDateString(),
//            ],
//
//            'summary' => [
//                'total_scheduled' => $totalScheduled,
//                'total_taken' => $totalTaken,
//                'total_missed' => $totalMissed,
//                'total_pending' => $totalPending,
//                'total_snoozed' => $totalSnoozed,
//                'total_skipped' => $totalSkipped,
//                'rate' => $rate,
//            ],
//
//            'daily' => $calendar,
//        ];
//
//        return ApiActions::generateResponse($data);
//    }






    private function authorizeLog(MedicationLog $medicationLog): void
    {
        $patient = auth()->user()->patient;

        abort_unless(
            $patient && $medicationLog->patientMedication &&$medicationLog->patientMedication->patient_id === $patient->id,
            403,
            'Unauthorized.'
        );
    }


}

