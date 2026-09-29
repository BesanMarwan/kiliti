<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\ApiActions;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\SmartNoteResource;
use App\Services\SmartNoteService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
class SmartNoteController extends Controller
{
    public $smartNoteService;
    public function __construct(SmartNoteService $smartNoteService){

        $this->smartNoteService = $smartNoteService;
    }
    #[OA\Get(
        path: '/api/v1/user/dashboard/smart-note',
        summary: 'Get patient smart note',
        tags: ['Dashboard'],
        security: [['api_key' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Smart note retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/SmartNoteResource',
                            nullable: true
                        ),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
            new OA\Response(
                response: 404,
                description: 'Patient profile not found'
            ),
        ]
    )]
    public function show(Request $request, SmartNoteService $smartNoteService)
    {
        $patient = $request->user()->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found.'], 404);
        }

        $smartNote = $this->smartNoteService->getForPatient($patient);
        if (!$smartNote) {
            return ApiActions::generateResponse(null);
        }
        return ApiActions::generateResponse(SmartNoteResource::make($smartNote));
    }

}
