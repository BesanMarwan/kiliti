<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\ApiActions;
use App\Constants\ResponseCode;
use App\Events\FluidLogCreated;
use App\Events\PatientAdherenceChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\FluidLogRequest;

use App\Http\Resources\User\FluidLogResource;
use App\Http\Resources\User\FluidLogSummaryResource;
use App\Models\FluidLog;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "FluidLogApiSection",
    description: "API Package for FluidLog requests"
)]
class FluidLogController extends Controller
{

    #[OA\Get(
        path: "/api/v1/user/fluid-logs",
        operationId: "getUserFluidLogs",
        tags: ["FluidLogApiSection"],
        summary: "Get today's fluid logs",
        description: "Returns the authenticated patient's fluid intake entries recorded today, ordered from newest to oldest, with today's fluid consumption summary.",
        security: [["api_key" => []]],

        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Today's fluid logs retrieved successfully",

                content: new OA\JsonContent(
                    type: "object",

                    properties: [

                        new OA\Property(
                            property: "fluid_limit",
                            type: "integer",
                            example: 1500,
                            description: "Daily fluid limit in milliliters."
                        ),

                        new OA\Property(
                            property: "total_amount",
                            type: "integer",
                            example: 1050,
                            description: "Total fluid consumed today in milliliters."
                        ),

                        new OA\Property(
                            property: "remains",
                            type: "integer",
                            example: 450,
                            description: "Remaining fluid allowance today in milliliters."
                        ),

                        new OA\Property(
                            property: "percentage",
                            type: "number",
                            format: "float",
                            example: 70.0,
                            description: "Percentage of today's fluid limit consumed."
                        ),

                        new OA\Property(
                            property: "is_exceeded",
                            type: "boolean",
                            example: false,
                            description: "Whether today's total fluid consumption exceeds the daily limit."
                        ),

                        new OA\Property(
                            property: "entries_count",
                            type: "integer",
                            example: 3,
                            description: "Number of fluid entries recorded today."
                        ),

                        new OA\Property(
                            property: "entries_label",
                            type: "string",
                            example: "3 مدخلات",
                            description: "Display label for the number of fluid entries."
                        ),

                        new OA\Property(
                            property: "logs",
                            type: "array",
                            description: "Today's fluid entries ordered from newest to oldest.",

                            items: new OA\Items(
                                ref: "#/components/schemas/FluidLogResource"
                            )
                        ),
                    ]
                )
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),

            new OA\Response(
                response: 403,
                description: "Only patients can access fluid logs"
            ),

            new OA\Response(
                response: 404,
                description: "No fluid logs found"
            ),
        ]
    )]
    public function getFluidLog(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'patient') {
            abort(403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return ApiActions::generateResponse(
                null,
                'patient_not_found',
                ResponseCode::NOT_FOUND
            );
        }

        $timezone = 'Asia/Gaza';

        $today = now($timezone)->toDateString();

        $logs = $patient->fluidLogs()
            ->whereDate('recorded_at', $today)
            ->orderByDesc('recorded_at')
            ->get();

        if ($logs->isEmpty()) {
            return ApiActions::generateResponse(
                null,
                'fluid_log_not_found',
                ResponseCode::NOT_FOUND
            );
        }

        $fluidLimit = (int) $patient->daily_fluid_limit;

        $totalAmount = (int) $logs->sum('amount_ml');

        $remains = max(
            0,
            $fluidLimit - $totalAmount
        );

        $percentage = $fluidLimit > 0
            ? round(
                ($totalAmount / $fluidLimit) * 100,
                1
            )
            : 0;

        $isExceeded = $totalAmount > $fluidLimit;

        $entriesCount = $logs->count();

        $entriesLabel = match (true) {
            $entriesCount === 1 =>
            'مدخل واحد',

            $entriesCount === 2 =>
            'مدخلان',

            $entriesCount >= 3 && $entriesCount <= 10 =>
                $entriesCount . ' مدخلات',

            default =>
                $entriesCount . ' مدخل',
        };

        $data = [
            'fluid_limit' => $fluidLimit,
            'total_amount' => $totalAmount,
            'remains' => $remains,
            'percentage' => $percentage,
            'is_exceeded' => $isExceeded,
            'entries_count' => $entriesCount,
            'entries_label' => $entriesLabel,
            'logs' => FluidLogResource::collection($logs),
        ];

        return ApiActions::generateResponse($data);
    }


    #[OA\Get(
        path: "/api/v1/user/fluid-logs/history",
        operationId: "getHistoryFluidLog",
        tags: ["FluidLogApiSection"],
        summary: "Get fluid logs history",
        description: "Get the patient's daily fluid consumption history and adherence summary.",

        security: [
            ["api_key" => []]
        ],

        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            ),

            new OA\Parameter(
                name: "days",
                in: "query",
                required: false,
                description: "Number of previous days to retrieve. Allowed range: 1-30.",
                schema: new OA\Schema(
                    type: "integer",
                    minimum: 1,
                    maximum: 30,
                    default: 7
                ),
                example: 7
            ),
        ],

        responses: [

            /*
            |--------------------------------------------------------------------------
            | 200
            |--------------------------------------------------------------------------
            */

            new OA\Response(
                response: 200,
                description: "Fluid history retrieved successfully",
                content: new OA\JsonContent(
                    type: "object",

                    properties: [

                        /*
                        |--------------------------------------------------------------------------
                        | Logs
                        |--------------------------------------------------------------------------
                        */

                        new OA\Property(
                            property: "logs",
                            type: "array",

                            items: new OA\Items(
                                type: "object",

                                properties: [

                                    new OA\Property(
                                        property: "date",
                                        type: "string",
                                        format: "date",
                                        example: "2026-10-07"
                                    ),

                                    new OA\Property(
                                        property: "day_name",
                                        type: "string",
                                        example: "الأربعاء"
                                    ),

                                    new OA\Property(
                                        property: "total_amount_ml",
                                        type: "integer",
                                        example: 1600
                                    ),

                                    new OA\Property(
                                        property: "fluid_limit_ml",
                                        type: "integer",
                                        example: 1500
                                    ),

                                    new OA\Property(
                                        property: "remaining_ml",
                                        type: "integer",
                                        example: 0
                                    ),

                                    new OA\Property(
                                        property: "exceeded_ml",
                                        type: "integer",
                                        example: 100
                                    ),

                                    new OA\Property(
                                        property: "is_exceeded",
                                        type: "boolean",
                                        example: true
                                    ),

                                    new OA\Property(
                                        property: "status",
                                        type: "string",
                                        enum: [
                                            "within_limit",
                                            "slightly_exceeded",
                                            "significantly_exceeded"
                                        ],
                                        example: "slightly_exceeded"
                                    ),
                                ]
                            )
                        ),

                        /*
                        |--------------------------------------------------------------------------
                        | Summary
                        |--------------------------------------------------------------------------
                        */

                        new OA\Property(
                            property: "summary",
                            type: "object",

                            properties: [

                                new OA\Property(
                                    property: "period_days",
                                    type: "integer",
                                    example: 7
                                ),

                                new OA\Property(
                                    property: "logged_days",
                                    type: "integer",
                                    example: 6
                                ),

                                new OA\Property(
                                    property: "days_within_limit",
                                    type: "integer",
                                    example: 5
                                ),

                                new OA\Property(
                                    property: "days_exceeded",
                                    type: "integer",
                                    example: 1
                                ),

                                new OA\Property(
                                    property: "adherence_percentage",
                                    type: "number",
                                    format: "float",
                                    example: 83.3
                                ),

                                new OA\Property(
                                    property: "adherence_label",
                                    type: "string",
                                    example: "التزام جيد"
                                ),
                            ]
                        ),
                    ]
                )
            ),

            /*
            |--------------------------------------------------------------------------
            | 401
            |--------------------------------------------------------------------------
            */

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),

            /*
            |--------------------------------------------------------------------------
            | 403
            |--------------------------------------------------------------------------
            */

            new OA\Response(
                response: 403,
                description: "User is not authorized to access fluid history"
            ),

            /*
            |--------------------------------------------------------------------------
            | 422
            |--------------------------------------------------------------------------
            */

            new OA\Response(
                response: 422,
                description: "Validation error",
                content: new OA\JsonContent(
                    type: "object",

                    properties: [

                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "The given data was invalid."
                        ),

                        new OA\Property(
                            property: "errors",
                            type: "object",

                            example: [
                                "days" => [
                                    "The days field must be between 1 and 30."
                                ]
                            ]
                        ),
                    ]
                )
            ),

            /*
            |--------------------------------------------------------------------------
            | 404
            |--------------------------------------------------------------------------
            */

            new OA\Response(
                response: 404,
                description: "No fluid logs found",
                content: new OA\JsonContent(
                    type: "object",

                    properties: [

                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "No fluid logs found."
                        ),
                    ]
                )
            ),
        ]
    )]
    public function getHistoryFluidLog(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'patient') {
            abort(403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return ApiActions::generateResponse(
                null,
                'patient_not_found',
                ResponseCode::NOT_FOUND
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validate days
        |--------------------------------------------------------------------------
        */
        $request->validate([
            'days' => ['nullable', 'integer', 'min:1', 'max:30'],
        ]);

        $days = (int) $request->input('days', 7);

        if ($days < 1 || $days > 30) {
            return ApiActions::generateResponse(
                null,
                'invalid_days',
                ResponseCode::VALIDATION_ERROR
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date Range
        |--------------------------------------------------------------------------
        */

        $timezone = 'Asia/Gaza';

        $from = Carbon::now($timezone)
            ->subDays($days - 1)
            ->startOfDay();

        $to = Carbon::now($timezone)
            ->endOfDay();

        /*
        |--------------------------------------------------------------------------
        | Get Daily Fluid Consumption
        |--------------------------------------------------------------------------
        */

        $logs = $patient->fluidLogs()
            ->select([
                DB::raw('DATE(recorded_at) as date'),
                DB::raw('SUM(amount_ml) as total_amount_ml'),
                DB::raw('MAX(fluid_limit) as fluid_limit_ml'),
            ])
            ->whereBetween('recorded_at', [
                $from,
                $to,
            ])
            ->groupBy(
                DB::raw('DATE(recorded_at)')
            )
            ->orderByDesc('date')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | No Logs
        |--------------------------------------------------------------------------
        */

        if ($logs->isEmpty()) {
            return ApiActions::generateResponse(
                null,
                'fluid_log_not_found',
                ResponseCode::NOT_FOUND
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Format Logs
        |--------------------------------------------------------------------------
        */

        $logs = $logs->map(function ($row) use ($timezone) {

            $totalAmount = (int) $row->total_amount_ml;
            $fluidLimit = (int) $row->fluid_limit_ml;

            $remaining = max(0, $fluidLimit - $totalAmount);
            $exceeded = max(0, $totalAmount - $fluidLimit);

            $status = match (true) {
                $exceeded === 0 => 'within_limit',
                $exceeded <= 250 => 'slightly_exceeded',
                default => 'significantly_exceeded',
            };

            $statusLabel = match ($status) {
                'within_limit' => 'ضمن الحد',
                'slightly_exceeded' => 'تجاوز بسيط',
                'significantly_exceeded' => 'تجاوز كبير',
            };

            return [
                'date' => $row->date,

                'day_name' => Carbon::parse($row->date, $timezone)
                    ->locale('ar')
                    ->dayName,

                'total_amount_ml' => $totalAmount,

                'fluid_limit_ml' => $fluidLimit,

                'remaining_ml' => $remaining,

                'exceeded_ml' => $exceeded,

                'is_exceeded' => $exceeded > 0,

                'status' => $status,

                'status_label' => $statusLabel,
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $loggedDays = $logs->count();

        $daysWithinLimit = $logs
            ->where('is_exceeded', false)
            ->count();

        $daysExceeded = $logs
            ->where('is_exceeded', true)
            ->count();

        $adherencePercentage = $loggedDays > 0
            ? round(
                ($daysWithinLimit / $loggedDays) * 100,
                1
            )
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Adherence Label
        |--------------------------------------------------------------------------
        */

        $adherenceLabel = match (true) {

            $adherencePercentage >= 90 =>
            'التزام ممتاز',

            $adherencePercentage >= 75 =>
            'التزام جيد',

            $adherencePercentage >= 50 =>
            'يحتاج إلى تحسين',

            default =>
            'التزام منخفض',
        };

        /*
        |--------------------------------------------------------------------------
        | Summary Response
        |--------------------------------------------------------------------------
        */

        $summary = [
            'period_days' => $days,

            'logged_days' => $loggedDays,

            'days_within_limit' => $daysWithinLimit,

            'days_exceeded' => $daysExceeded,

            'adherence_percentage' => $adherencePercentage,

            'adherence_label' => $adherenceLabel,
        ];

        /*
        |--------------------------------------------------------------------------
        | Final Response
        |--------------------------------------------------------------------------
        */

        return ApiActions::generateResponse([
            'logs' => $logs,
            'summary' => $summary,
        ]);
    }

    #[OA\Post(
        path: "/api/v1/user/fluid-logs/add",
        operationId: "addFluidLog",
        tags: ["FluidLogApiSection"],
        summary: "add fluid log API",
        description: "add fluid log returns fluid lig object",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: "#/components/schemas/FluidLog"
            )
        ),
        security: [["api_key" => []]],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/language"),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Fluid log created successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "log",
                            ref: "#/components/schemas/FluidLogResource"
                        ),
                    ],
                    type: "object"
                )
            ),
            new OA\Response(
                response: 422,
                description: "Validation error",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "The given data was invalid."
                        ),
                        new OA\Property(
                            property: "errors",
                            type: "object",
                            example: [
                                "amount_ml" => [
                                    "كمية السائل يجب أن تكون من مضاعفات 50 مل."
                                ]
                            ]
                        ),
                    ]
                )
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),

            new OA\Response(
                response: 403,
                description: "User is not allowed to add fluid logs"
            ),
        ]
    )]
    public function addFluidLog(FluidLogRequest $request)
    {
        $user = $request->user();
        if($user->role != 'patient'){
            abort(404);
        }
        $patient      = $user->patient;
        $fluid_limit  = $patient->daily_fluid_limit;

        $log              = new FluidLog();
        $log->fluid_type  = $request->fluid_type;
        $log->fluid_limit = $fluid_limit;
        $log->amount_ml   = $request->amount_ml;
        $log->patient_id  = $patient->id;
        $log->recorded_at = Carbon::now();
        $log->save();
        $log->fresh();

        FluidLogCreated::dispatch($log);
        PatientAdherenceChanged::dispatch($log->patient_id);


        $log = FluidLogResource::make($log);

        return ApiActions::generateResponse(compact('log'));

    }

    #[OA\Get(
        path: "/api/v1/user/fluid-logs/summary",
        summary: "Get today's fluid intake summary for dashboard",
        description: "Returns the authenticated patient's fluid intake summary for the current day.",
        security: [["api_key" => []]],
        tags: ["FluidLogApiSection"],
        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            )
        ],


        responses: [
            new OA\Response(
                response: 200,
                description: "Fluid summary retrieved successfully",
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
                            ref: "#/components/schemas/FluidLogSummaryResource"
                        )
                    ]
                )
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated",
                content: new OA\JsonContent(
                    example: [
                        "status" => false,
                        "message" => "Unauthenticated."
                    ]
                )
            ),
            new OA\Response(
                response: 403,
                description: "Forbidden",
                content: new OA\JsonContent(
                    example: [
                        "status" => false,
                        "message" => "You are not authorized to access this resource."
                    ]
                )
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

        $today      = now('Asia/Gaza')->toDateString();
        $dailyLimit = (float) $patient->daily_fluid_limit;
        $consumed   = (float) $patient->fluidLogs()->whereDate('recorded_at', $today)->sum('amount_ml');
        $remaining  = max($dailyLimit - $consumed, 0);
        $percentage = $dailyLimit > 0 ? round(($consumed / $dailyLimit) * 100, 2) : 0;

        $data = [
            'daily_limit_ml' => $dailyLimit,
            'consumed_ml'    => $consumed,
            'remaining_ml'   => $remaining,
            'percentage'     => $percentage,
            'is_exceeded'    => $dailyLimit > 0 && $consumed > $dailyLimit
        ];

        return ApiActions::generateResponse( FluidLogSummaryResource::make($data));
    }


}
