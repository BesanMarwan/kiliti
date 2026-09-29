<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\DashboardAlertResource;
use App\Services\DashboardAlertService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class DashboardAlertController extends Controller
{
    public function __construct(protected DashboardAlertService $dashboardAlertService) {}

    #[OA\Get(
        path: '/api/v1/user/dashboard/alerts',
        summary: 'Get patient dashboard alerts',
        description: 'Returns the important alerts that should be displayed on the patient dashboard.',
        tags: ['Dashboard'],
        security: [['api_key' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Dashboard alerts retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                ref: '#/components/schemas/DashboardAlertResource'
                            )
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
    public function index(Request $request)
    {
        $patient = $request->user()->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found.'], 404);
        }

        $alerts = $this->dashboardAlertService->getForPatient($patient);

        return DashboardAlertResource::collection($alerts);
    }
}
