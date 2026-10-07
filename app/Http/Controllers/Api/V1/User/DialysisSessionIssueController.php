<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\ApiActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\DialysisSessionIssueRequest;
use App\Http\Resources\User\DialysisSessionIssueResource;
use App\Models\DialysisSession;
use App\Models\DialysisSessionIssue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Dialysis Session Issues",
    description: "Patient dialysis session issues and alerts"
)]
class DialysisSessionIssueController extends Controller
{
    #[OA\Post(
        path: "/api/v1/user/dialysis-sessions/{dialysisSession}/issues",
        summary: "Report an issue during a dialysis session",
        security: [["api_key" => []]],
        tags: ["Dialysis Session Issues"]
    )]
    #[OA\Parameter(
        name: "dialysisSession",
        description: "Dialysis session ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer", example: 15)
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["issue_type", "severity"],
            properties: [
                new OA\Property(
                    property: "issue_type",
                    type: "string",
                    enum: [
                        "dizziness",
                        "severe_fatigue",
                        "nausea_pain",
                        "cramps",
                        "machine_problem",
                        "needle_problem",
                        "other"
                    ],
                    example: "dizziness"
                ),
                new OA\Property(
                    property: "severity",
                    type: "string",
                    enum: ["mild", "moderate", "severe"],
                    example: "moderate"
                ),
                new OA\Property(
                    property: "description",
                    type: "string",
                    nullable: true,
                    example: "أشعر بدوخة منذ عدة دقائق"
                ),
                new OA\Property(
                    property: "reported_at",
                    type: "string",
                    format: "date-time",
                    nullable: true,
                    example: "2026-09-28T14:30:00+03:00"
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Issue reported successfully",
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
                    example: "تم تسجيل المشكلة بنجاح"
                ),
                new OA\Property(
                    property: "data",
                    ref: "#/components/schemas/DialysisSessionIssueResource"
                )
            ]
        )
    )]
    #[OA\Response(
        response: 403,
        description: "Unauthorized session"
    )]
    #[OA\Response(
        response: 422,
        description: "Validation error"
    )]
    public function store(DialysisSessionIssueRequest $request, DialysisSession $dialysisSession) {
        $patient = $request->user()->patient;

        $issue = DialysisSessionIssue::create([
            'dialysis_session_id' => $dialysisSession->id,
            'patient_id'          => $patient->id,
            'issue_type'          => $request->issue_type,
            'severity'            => $request->severity,
            'description'         => $request->description,
            'reported_at'         => $request->reported_at ? now()->parse($request->reported_at) : now('Asia/Gaza'),
            'status'              => 'open',
        ]);

        return ApiActions::generateResponse(DialysisSessionIssueResource::make($issue),'dialysis_issue_send_done');
    }


    #[OA\Get(
        path: "/api/v1/user/dialysis-sessions/{dialysisSession}/issues",
        summary: "Get issues reported during a dialysis session",
        security: [["api_key" => []]],
        tags: ["Dialysis Session Issues"]
    )]
    #[OA\Parameter(
        name: "dialysisSession",
        description: "Dialysis session ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer", example: 15)
    )]
    #[OA\Response(
        response: 200,
        description: "Session issues",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "success",
                    type: "boolean",
                    example: true
                ),
                new OA\Property(
                    property: "data",
                    type: "array",
                    items: new OA\Items(
                        ref: "#/components/schemas/DialysisSessionIssueResource"
                    )
                )
            ]
        )
    )]
    #[OA\Response(
        response: 403,
        description: "Unauthorized session"
    )]
    public function index(Request $request, DialysisSession $dialysisSession) {

        $patient = $request->user()->patient;

        abort_unless($patient && $dialysisSession->patient_id === $patient->id, 403);

        $issues = $dialysisSession->issues()->latest('reported_at')->get();

        return ApiActions::generateResponse(DialysisSessionIssueResource::collection($issues));
    }


    #[OA\Get(
        path: "/api/v1/user/dialysis-session-issues/history",
        summary: "Get patient's dialysis issues history",
        security: [["api_key" => []]],
        tags: ["Dialysis Session Issues"]
    )]
    #[OA\Parameter(
        name: "reported_at_from",
        description: "Start date",
        in: "query",
        required: false,
        schema: new OA\Schema(
            type: "string",
            format: "date",
            example: "2026-09-01"
        )
    )]
    #[OA\Parameter(
        name: "reported_at_to",
        description: "End date",
        in: "query",
        required: false,
        schema: new OA\Schema(
            type: "string",
            format: "date",
            example: "2026-09-28"
        )
    )]
    #[OA\Parameter(
        name: "status",
        description: "Issue status",
        in: "query",
        required: false,
        schema: new OA\Schema(
            type: "string",
            enum: ["open", "acknowledged", "resolved"]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Issues history",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "success",
                    type: "boolean",
                    example: true
                ),
                new OA\Property(
                    property: "data",
                    type: "array",
                    items: new OA\Items(
                        ref: "#/components/schemas/DialysisSessionIssueResource"
                    )
                )
            ]
        )
    )]
    public function history(Request $request): JsonResponse
    {
        $patient = $request->user()->patient;

        abort_unless($patient, 403);

        $issues = DialysisSessionIssue::query()->filter()->where('patient_id', $patient->id)->latest('reported_at')->get();

        return ApiActions::generateResponse(DialysisSessionIssueResource::collection($issues));
    }


}
