<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\ApiActions;
use App\Constants\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\DialysisSessionRequest;
use App\Http\Resources\User\DialysisSessionDetailsResource;
use App\Http\Resources\User\DialysisSessionResource;
use App\Models\DialysisSession;
use Carbon\Carbon;
use Illuminate\Http\Request;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "DialysisSessionsApiSection",
    description: "API Package for Patient Dialysis Sessions"
)]
class DialysisSessionController extends Controller
{

    #[OA\Get(
        path: "/api/v1/user/dialysis-sessions",
        operationId: "getPatientDialysisSessions",
        tags: ["DialysisSessionsApiSection"],
        summary: "Get Patient Dialysis Sessions",
        description: "Get the authenticated patient's dialysis sessions. Use type=upcoming for upcoming sessions or type=past for previous sessions.",
        security: [["api_key" => []]],
        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            ),

            new OA\Parameter(
                name: "type",
                description: "Filter sessions by time.",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    enum: [
                        "upcoming",
                        "past"
                    ],
                    default: "upcoming"
                ),
                example: "upcoming"
            ),

            new OA\Parameter(
                name: "from",
                description: "Start date in Y-m-d format. Optional.",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    format: "date",
                    example: "2026-10-01"
                )
            ),

            new OA\Parameter(
                name: "to",
                description: "End date in Y-m-d format. Optional.",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    format: "date",
                    example: "2026-10-31"
                )
            ),
        ],
        responses: [

            new OA\Response(
                response: 200,
                description: "Dialysis sessions retrieved successfully.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "status",
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
                                ref: "#/components/schemas/DialysisSessionResource"
                            )
                        )
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
    public function index(DialysisSessionRequest $request)
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

        $query = DialysisSession::query()
            ->where('patient_id', $patient->id)
            ->with([
                'center',
                'doctor.user',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Session Type
        |--------------------------------------------------------------------------
        */

        if ($request->type === 'upcoming') {

            $query
                ->whereIn('status', [
                    'scheduled',
                    'confirmed',
                ])
                ->where(
                    'scheduled_at',
                    '>=',
                    now($timezone)
                )
                ->orderBy('scheduled_at');

        } elseif ($request->type === 'past') {

            $query
                ->whereIn('status', [
                    'completed',
                    'missed',
                    'cancelled',
                ])
                ->orderByDesc('scheduled_at');

        } else {

            $query
                ->orderByDesc('scheduled_at');

        }


        /*
        |--------------------------------------------------------------------------
        | Date Range
        |--------------------------------------------------------------------------
        */

        if ($request->filled('from')) {

            $from = Carbon::createFromFormat(
                'Y-m-d',
                $request->from(),
                $timezone
            )->startOfDay();

            $query->where(
                'scheduled_at',
                '>=',
                $from
            );
        }


        if ($request->filled('to')) {

            $to = Carbon::createFromFormat(
                'Y-m-d',
                $request->to(),
                $timezone
            )->endOfDay();

            $query->where(
                'scheduled_at',
                '<=',
                $to
            );
        }


        $sessions = $query->get();


        return ApiActions::generateResponse(
            DialysisSessionResource::collection($sessions)
        );
    }

    #[OA\Get(
        path: "/api/v1/user/dialysis-sessions/next",
        summary: "Get next dialysis session",
        description: "Returns the next upcoming dialysis session for the authenticated patient.",
        security: [["api_key" => []]],
        tags: ["DialysisSessionsApiSection"],
        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            ),
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Next dialysis session retrieved successfully",
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
                            ref: "#/components/schemas/DialysisSessionResource"
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
    public function next(Request $request)
    {
        $patient = $request->user()->patient;

        abort_unless($patient, 404, 'Patient profile not found.');

        $session = DialysisSession::query()
                            ->where('patient_id', $patient->id)
                            ->whereIn('status', ['scheduled', 'confirmed'])
                            ->where('scheduled_at', '>', now('Asia/Gaza'))
                            ->with(['center', 'doctor.user',])
                            ->orderBy('scheduled_at')
                            ->first();

        if (!$session) {
            return ApiActions::generateResponse(null, 'No upcoming dialysis session found.');
        }

        return ApiActions::generateResponse( DialysisSessionResource::make($session));
    }


    #[OA\Get(
        path: "/api/v1/user/dialysis-sessions/{dialysisSession}",
        operationId: "getPatientDialysisSessionDetails",
        tags: ["DialysisSessionsApiSection"],
        summary: "Get Dialysis Session Details",
        description: "Get details of a dialysis session belonging to the authenticated patient.",
        security: [["api_key" => []]],

        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            ),

            new OA\Parameter(
                name: "dialysisSession",
                description: "Dialysis session ID.",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer",
                    format: "int64"
                ),
                example: 15
            ),
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Dialysis session retrieved successfully.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "status",
                            type: "boolean",
                            example: true
                        ),

                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/DialysisSessionDetailsResource"
                        ),
                    ]
                )
            ),

            new OA\Response(
                response: 403,
                description: "Unauthorized access to this dialysis session."
            ),

            new OA\Response(
                response: 404,
                description: "Dialysis session or patient profile not found."
            ),
        ]
    )]
    public function show(Request $request, DialysisSession $dialysisSession)
    {
        $patient = $request->user()->patient;

        if (!$patient) {
            return ApiActions::generateResponse(null, 'patient_profile_not_found.', ResponseCode::NOT_FOUND);
        }

        if ($dialysisSession->patient_id !== $patient->id) {
            return ApiActions::generateResponse(null, 'unauthorized.', ResponseCode::UNAUTHORIZED
            );
        }

        $dialysisSession->load(['center', 'doctor.user', 'record']);

        return ApiActions::generateResponse(new DialysisSessionDetailsResource($dialysisSession));
    }


    #[OA\Post(
        path: "/api/v1/user/dialysis-sessions/{dialysisSession}/confirm",
        summary: "Confirm dialysis session attendance",
        description: "Allows the authenticated patient to confirm that they intend to attend a scheduled dialysis session.",
        security: [["sanctum" => []]],
        tags: ["DialysisSessionsApiSection"],
        parameters: [
            new OA\Parameter(
                name: "dialysisSession",
                description: "Dialysis session ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer", example: 15)
            ),
            new OA\Parameter(
                ref: "#/components/parameters/language"
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Dialysis session confirmed successfully",
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
                            example: "Dialysis session confirmed successfully."
                        ),
                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "id",
                                    type: "integer",
                                    example: 15
                                ),
                                new OA\Property(
                                    property: "status",
                                    type: "string",
                                    example: "confirmed"
                                ),
                                new OA\Property(
                                    property: "scheduled_at",
                                    type: "string",
                                    format: "date-time",
                                    example: "2026-09-27 09:00:00"
                                )
                            ]
                        )
                    ]
                )
            ),

            new OA\Response(
                response: 403,
                description: "Unauthorized"
            ),

            new OA\Response(
                response: 422,
                description: "Session cannot be confirmed"
            )
        ]
    )]
    public function confirm(DialysisSession $dialysisSession)
    {
        $patient = auth()->user()->patient;

        abort_unless($patient && $dialysisSession->patient_id === $patient->id, 403, 'Unauthorized.');

        if ($dialysisSession->status === 'confirmed') {
            return ApiActions::generateResponse(null, 'The dialysis session is already confirmed.', ResponseCode::VALIDATION_ERROR);
        }

        if ($dialysisSession->status !== 'scheduled') {
            return ApiActions::generateResponse(null, 'This dialysis session cannot be confirmed.', ResponseCode::VALIDATION_ERROR);
        }

        if ($dialysisSession->scheduled_at->isPast()) {
            return ApiActions::generateResponse(null, 'This dialysis session has already started or passed.', ResponseCode::VALIDATION_ERROR);
        }

        $dialysisSession->update(['status' => 'confirmed',]);

        $dialysisSession->load(['center', 'doctor.user',]);

        return ApiActions::generateResponse(new DialysisSessionResource($dialysisSession), 'Dialysis session confirmed successfully.');
    }
}
