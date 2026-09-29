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
        operationId: "GetUserFluidLog",
        tags: ["FluidLogApiSection"],
        summary: "Get user fluid logs API",
        description: "Get user  fluid logs today service",
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
    public function getFluidLog(Request $request)
    {
        $user  = $request->user();
        $fluid = $user->patient->fluidLogs()->whereDate('created_at',today())->orderByDesc('id');
        $logs  = $fluid->get();
        if (!$logs) {
            return ApiActions::generateResponse(null, 'fluid_log_not_found', ResponseCode::NOT_FOUND);
        }

        $data['fluid_limit']       = $user->patient->daily_fluid_limit;
        $data['total_amount']      = (integer)$fluid->sum('amount_ml');
        $data['remains']           = $user->patient->daily_fluid_limit - (integer)$fluid->sum('amount_ml');
        $data['percentage']        = round(($data['total_amount']/$data['fluid_limit'])*100,1);
        $data['is_exceeded']       = $data['total_amount'] > $data['total_amount'];
        $data['logs']              = FluidLogResource::collection($logs);

        return ApiActions::generateResponse($data);
    }


    #[OA\Get(
        path: "/api/v1/user/fluid-logs/history",
        operationId: "GetHistoryFluidLog",
        tags: ["FluidLogApiSection"],
        summary: "Get user history fluid logs API",
        description: "Get user history  fluid logs service",
        security: [["api_key" => []]],
        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "successful operation with status = true and fluid logs array of objects"
            )
        ]
    )]
    public function getHistoryFluidLog(Request $request)
    {
        $user  = $request->user();
        $logs = $user->patient->fluidLogs()->selectRaw('DATE(recorded_at) as date,CAST(SUM(amount_ml) AS UNSIGNED) as total_amount,CAST(MAX(fluid_limit) AS UNSIGNED) as fluid_limit')
                               ->orderByDesc('recorded_at')
                               ->groupBy(DB::raw('DATE(recorded_at)'))
                               ->get()->map(function($row)use($user){
                                   $row->is_exceeded= $row->total_amount > $row->fluid_limit;
                                   return $row;});
        if (!$logs) {
            return ApiActions::generateResponse(null, 'fluid_log_not_found', ResponseCode::NOT_FOUND);
        }

        return ApiActions::generateResponse(compact('logs'));
    }


    #[OA\Post(
        path: "/api/v1/user/fluid-logs/add",
        operationId: "addFluidLog",
        tags: ["FluidLogApiSection"],
        summary: "add fluid log API",
        description: "add fluid log returns fluid lig object",
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    ref: "#/components/schemas/FluidLog"
                )
            )
        ),
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/language"),
            new OA\Parameter(ref: "#/components/parameters/device_key"),
            new OA\Parameter(ref: "#/components/parameters/device_name"),
            new OA\Parameter(ref: "#/components/parameters/device_type")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/UserResource"
                )
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            ),
            new OA\Response(
                response: 451,
                description: "Not verified : User need confirm mobile",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/UserResource"
                )
            )
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
