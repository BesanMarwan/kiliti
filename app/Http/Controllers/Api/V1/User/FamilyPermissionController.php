<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\ApiActions;
use App\Constants\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\RestoreFamilyMemberRequest;
use App\Http\Requests\Api\User\UpdateFamilyPermissionsRequest;
use App\Http\Resources\User\FamilyInvitationDetailsResource;
use App\Http\Resources\User\FamilyPermissionTypeResource;
use App\Models\FamilyPermission;
use App\Models\FamilyPermissionType;
use App\Models\PatientFamilyMember;
use App\Services\FamilyPermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

class FamilyPermissionController extends Controller
{

    #[OA\Get(
        path: "/api/v1/user/family/members/permission-types",
        operationId: "getFamilyPermissionTypes",
        summary: "Get family permission types",
        description: "Retrieve all available permission types that can be assigned to a family member.",
        security: [["api_key" => []]],
        tags: ["Family Permissions"],
        parameters: [
            new OA\Parameter(
                parameter: "language",
                ref: "#/components/parameters/language"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Family permission types retrieved successfully.",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Family permission types retrieved successfully."
                        ),
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                ref: "#/components/schemas/FamilyPermissionType"
                            )
                        ),
                    ]
                )
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated."
            ),
        ]
    )]
    public function permissionTypes()
    {
         $permissions = FamilyPermissionType::query()->orderBy('id')->get();
         $permissions = FamilyPermissionTypeResource::collection($permissions);
        return ApiActions::generateResponse(compact('permissions'));

    }
    #[OA\Put(
        path: "/api/v1/user/family/members/{patientFamilyMember}/permissions",
        operationId: "updateFamilyMemberPermissions",
        summary: "Update family member permissions",
        description: "Update the permissions of a family member for the authenticated patient.",
        security: [["api_key" => []]],
        tags: ["Family Permissions"],
        parameters: [
            new OA\Parameter(
                name: "patientFamilyMember",
                description: "Patient family member ID",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer",
                    example: 7
                )
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["permissions"],
                properties: [
                    new OA\Property(
                        property: "permissions",
                        type: "array",
                        minItems: 1,
                        items: new OA\Items(
                            type: "string",
                            enum: [
                                "view_medications",
                                "view_dialysis_sessions",
                                "view_fluid_data",
                                "view_symptoms",
                                "view_labs",
                                "view_measurements",
                                "receive_alerts"
                            ]
                        ),
                        example: [
                            "view_medications",
                            "view_fluid_data",
                            "receive_alerts"
                        ]
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Family member permissions updated successfully."
            ),
            new OA\Response(
                response: 401,
                description: "Unauthenticated."
            ),
            new OA\Response(
                response: 403,
                description: "Only the patient can manage family member permissions."
            ),
            new OA\Response(
                response: 404,
                description: "Family member relationship not found."
            ),
            new OA\Response(
                response: 422,
                description: "Validation error."
            ),
        ]
    )]
    public function update(UpdateFamilyPermissionsRequest $request, PatientFamilyMember $patientFamilyMember, FamilyPermissionService $familyPermissionService): JsonResponse {

        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Make sure this relationship belongs to the authenticated patient
        |--------------------------------------------------------------------------
        */

        if (!$user->patient || $patientFamilyMember->patient_id !== $user->patient->id) {
            return ApiActions::generateResponse(null, 'Family_member_not_found', ResponseCode::NOT_FOUND);
        }

        /*
        |--------------------------------------------------------------------------
        | Only active family members can have their permissions managed
        |--------------------------------------------------------------------------
        */

        if ($patientFamilyMember->status !== 'active') {
            return ApiActions::generateResponse(null, 'Permissions_can_only_be_managed_for_active_family_members', ResponseCode::NOT_FOUND);
        }

        /*
        |--------------------------------------------------------------------------
        | Update permissions
        |--------------------------------------------------------------------------
        */

        $patientFamilyMember = $familyPermissionService->update($patientFamilyMember, $request->validated('permissions'));

        return response()->json([
            'message' =>
                'Family member permissions updated successfully.',

            'data' => [
                'patient_family_member_id' =>
                    $patientFamilyMember->id,

                'family_member' => [
                    'id' =>
                        $patientFamilyMember->familyMember->id,

                    'name' =>
                        $patientFamilyMember->familyMember->user?->name,

                    'mobile' =>
                        $patientFamilyMember->familyMember->user?->mobile,

                    'relationship' =>
                        $patientFamilyMember->relationship,

                    'status' =>
                        $patientFamilyMember->status,
                ],

                'permissions' =>
                    $patientFamilyMember->permissions
                        ->map(fn ($permission) => [
                            'id' =>
                                $permission->permission_type_id,

                            'name' =>
                                $permission->permissionType?->name,

                            'label' =>
                                $permission->permissionType?->label,
                        ])
                        ->values(),
            ],
        ]);
    }


    #[OA\Patch(
        path: "/api/v1/user/family/members/{patientFamilyMember}/revoke",
        operationId: "revokeFamilyMemberAccess",
        summary: "Revoke family member access",
        description: "Revoke a family member's access to the authenticated patient's data.",
        security: [["api_key" => []]],
        tags: ["Family Permissions"],
        parameters: [
            new OA\Parameter(
                name: "patientFamilyMember",
                description: "Patient family member ID",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer",
                    example: 7
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Family member access revoked successfully."
            ),
            new OA\Response(
                response: 401,
                description: "Unauthenticated."
            ),
            new OA\Response(
                response: 404,
                description: "Family member relationship not found."
            ),
            new OA\Response(
                response: 422,
                description: "Family member access is already revoked."
            ),
        ]
    )]
    public function revoke(Request $request, PatientFamilyMember $patientFamilyMember, FamilyPermissionService $familyPermissionService): JsonResponse {

        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Make sure this relationship belongs to the authenticated patient
        |--------------------------------------------------------------------------
        */

        if (!$user->patient || $patientFamilyMember->patient_id !== $user->patient->id) {
            return response()->json([
                'message' => 'Family member not found.',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Make sure the relationship is currently active
        |--------------------------------------------------------------------------
        */

        if ($patientFamilyMember->status !== 'active') {
            return response()->json([
                'message' =>
                    'Family member access is not active.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Revoke access
        |--------------------------------------------------------------------------
        */

        $patientFamilyMember = $familyPermissionService->revoke($patientFamilyMember);

        return response()->json([
            'message' =>
                'Family member access revoked successfully.',

            'data' => [
                'patient_family_member_id' =>
                    $patientFamilyMember->id,

                'family_member' => [
                    'id' =>
                        $patientFamilyMember->familyMember->id,

                    'name' =>
                        $patientFamilyMember->familyMember->user?->name,

                    'mobile' =>
                        $patientFamilyMember->familyMember->user?->mobile,

                    'relationship' =>
                        $patientFamilyMember->relationship,

                    'status' =>
                        $patientFamilyMember->status,
                ],

                'permissions' => [],
            ],
        ]);
    }

    #[OA\Patch(
        path: "/api/v1/user/family/members/{patientFamilyMember}/restore",
        operationId: "restoreFamilyMemberAccess",
        summary: "Restore family member access",
        description: "Restore a revoked family member's access to the authenticated patient's data and assign new permissions.",
        security: [["api_key" => []]],
        tags: ["Family Permissions"],
        parameters: [
            new OA\Parameter(
                name: "patientFamilyMember",
                description: "Patient family member ID",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer",
                    example: 7
                )
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["permissions"],
                properties: [
                    new OA\Property(
                        property: "permissions",
                        type: "array",
                        minItems: 1,
                        items: new OA\Items(
                            type: "string",
                            enum: [
                                "view_medications",
                                "view_dialysis_sessions",
                                "view_fluid_data",
                                "view_symptoms",
                                "view_labs",
                                "view_measurements",
                                "receive_alerts"
                            ]
                        ),
                        example: [
                            "view_medications",
                            "view_fluid_data",
                            "receive_alerts"
                        ]
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Family member access restored successfully."
            ),
            new OA\Response(
                response: 401,
                description: "Unauthenticated."
            ),
            new OA\Response(
                response: 404,
                description: "Family member relationship not found."
            ),
            new OA\Response(
                response: 422,
                description: "Family member access is not revoked or validation failed."
            ),
        ]
    )]
    public function restore(PatientFamilyMember $patientFamilyMember, RestoreFamilyMemberRequest $request): PatientFamilyMember {

        $permissions = $request->permissions;
        return DB::transaction(function () use ($patientFamilyMember, $permissions) {

            $permissionTypeIds = FamilyPermissionType::query()
                ->whereIn('name', $permissions)
                ->pluck('id');

            $patientFamilyMember->update([
                'status' => 'active',
            ]);

            FamilyPermission::query()
                ->where(
                    'patient_family_member_id',
                    $patientFamilyMember->id
                )
                ->delete();

            foreach ($permissionTypeIds as $permissionTypeId) {
                FamilyPermission::create([
                    'patient_family_member_id' =>
                        $patientFamilyMember->id,

                    'permission_type_id' =>
                        $permissionTypeId,
                ]);
            }

            return $patientFamilyMember->load([
                'familyMember.user',
                'permissions.permissionType',
            ]);
        });
    }




}
