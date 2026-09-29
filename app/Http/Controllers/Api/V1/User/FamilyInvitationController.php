<?php

namespace App\Http\Controllers\Api\V1\User;

use OpenApi\Attributes as OA;
use App\Actions\ApiActions;
use App\Constants\ResponseCode;
use App\Enums\FamilyInvitationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\FamilyInvitationRequest;
use App\Http\Requests\Api\User\FamilyMemberRegisterRequest;
use App\Http\Resources\User\FamilyInvitationDetailsResource;
use App\Http\Resources\User\FamilyInvitationListResource;
use App\Http\Resources\User\FamilyInvitationResource;
use App\Http\Resources\User\UserResource;
use App\Models\FamilyInvitation;
use App\Models\FamilyInvitationPermission;
use App\Models\FamilyPermissionType;
use App\Models\PatientFamilyMember;
use App\Models\User;
use App\Services\FamilyInvitationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


#[OA\Tag(
    name: "Family Invitations",
    description: "API Package for Family Invitation requests"
)]
class FamilyInvitationController extends Controller
{
    #[OA\Get(
        path: "/api/v1/user/family/invitations",
        operationId: "getPatientFamilyInvitations",
        summary: "Get patient family invitations",
        description: "Retrieve all family invitations sent by the authenticated patient.",
        security: [["api_key" => []]],
        tags: ["Family Invitations"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Family invitations retrieved successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/FamilyInvitationList"
                        ),
                    ],
                    type: "object"
                )
            ),
            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),
            new OA\Response(
                response: 403,
                description: "Only patients can access family invitations"
            )
        ]
    )]
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'patient') {
            return ApiActions::generateResponse(null, 'Only_patients_can_access_family_invitations', ResponseCode::VALIDATION_ERROR);
        }

        $patient = $user->patient;

        $invitations = FamilyInvitationListResource::collection($patient->familyInvitations()->latest()->get());
        return ApiActions::generateResponse($invitations);
    }

    #[OA\Get(
        path: "/api/v1/user/family/invitations/{invitation}",
        operationId: "getFamilyInvitationDetails",
        tags: ["Family Invitations"],
        summary: "Get family invitation details",
        description: "Retrieve details of a family invitation created by the authenticated patient, including the family member and their permissions for this patient.",
        security: [["api_key" => []]],
        parameters: [
            new OA\Parameter(
                name: "invitation",
                description: "Family invitation ID",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer",
                    example: 12
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Family invitation details retrieved successfully.",
                content: new OA\JsonContent(
                    properties: [

                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/FamilyInvitationDetails"
                        ),
                    ],
                    type: "object"
                )
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated."
            ),

            new OA\Response(
                response: 403,
                description: "Only patients can access family invitations."
            ),

            new OA\Response(
                response: 404,
                description: "Invitation not found."
            ),
        ]
    )]
    public function details(Request $request, FamilyInvitation $invitation) {

        return $request;
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Patient only
        |--------------------------------------------------------------------------
        */

        if ($user->role !== 'patient') {
            return ApiActions::generateResponse(null, 'Only_patients_can_access_family_invitations', ResponseCode::VALIDATION_ERROR);
        }

        /*
        |--------------------------------------------------------------------------
        | Make sure invitation belongs to authenticated patient
        |--------------------------------------------------------------------------
        */

        $patient = $user->patient;

        if (!$patient || $invitation->patient_id !== $patient->id) {
            return ApiActions::generateResponse(null, 'Invitation_not_found', ResponseCode::NOT_FOUND);

        }

        /*
        |--------------------------------------------------------------------------
        | Load invitation permissions
        |--------------------------------------------------------------------------
        */

        $invitation->load([
            'permissions.permissionType',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Find the family relationship for THIS patient only
        |--------------------------------------------------------------------------
        */

        $patientFamilyMember = null;

        if ($invitation->status === FamilyInvitationStatus::ACCEPTED && $invitation->accepted_by_user_id) {
            $patientFamilyMember = PatientFamilyMember::with(['familyMember.user', 'permissions.permissionType',])
                ->where('patient_id', $patient->id)
                ->whereHas('familyMember', function ($query) use ($invitation) {
                    $query->where(
                        'user_id',
                        $invitation->accepted_by_user_id
                    );
                })
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Attach temporary relations to the invitation model
        |--------------------------------------------------------------------------
        */

        if ($patientFamilyMember) {
            $invitation->setRelation('patientFamilyMember', $patientFamilyMember);

            $invitation->setRelation('familyMember', $patientFamilyMember->familyMember);
        }

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */
        $invitation = FamilyInvitationDetailsResource::make($invitation);
        return ApiActions::generateResponse($invitation);



    }


    #[OA\Post(
        path: "/api/v1/user/family-members/invite",
        operationId: "sendFamilyInvitation",
        tags: ["Family Invitations"],
        summary: "User  register family member info API ",
        description: "Send an invitation to a family member with selected permissions.",
        security: [["api_key" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: "#/components/schemas/CreateFamilyInvitation"
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
                description: "successful operation with status = true and user object"
            ),

            new OA\Response(
                response: 422,
                description: "status = true : User not activated || status = false : User not found or password is not correct"
            )
        ]
    )]
    public function familyInvitation(FamilyInvitationRequest $request)
    {

        return $permissions = $request->input('permissions', []);

        $user = \auth()->user();

        if($user->role != 'patient'){
            return ApiActions::generateResponse(null, 'Only_patients_can_send_family_invitations', ResponseCode::VALIDATION_ERROR);
        }

        $patient = $user->patient;

        if (!$patient) {
            return ApiActions::generateResponse(null, 'Patient_profile_not_found', ResponseCode::VALIDATION_ERROR);
        }

        try{
            $existingInvitation = FamilyInvitation::where('patient_id',$patient->id)
                                   ->where('status', FamilyInvitationStatus::PENDING)
                                  ->where('mobile', $request->mobile)
                                   ->first();

            if ($existingInvitation) {
                return ApiActions::generateResponse(null, 'pending_invitation_already_exists', ResponseCode::VALIDATION_ERROR);
            }

            $plainToken = bin2hex(random_bytes(32));

            $invitation = DB::transaction(function () use ($request, $patient, $plainToken) {
                $invitation = FamilyInvitation::create([
                    'patient_id' => $patient->id,
                    'mobile' => $request->mobile,
                    'relationship' => $request->relationship,
                    'token_hash' => hash('sha256', $plainToken),
                    'status' => FamilyInvitationStatus::PENDING,
                    'expires_at' => now()->addDays(3),
                ]);

                $permissions = $request->input('permissions', []);

                if (!empty($permissions)) {
                    $permissionTypes = FamilyPermissionType::whereIn('name', $permissions)->get();

                    foreach ($permissionTypes as $permissionType) {
                        FamilyInvitationPermission::create([
                            'family_invitation_id' => $invitation->id,
                            'permission_type_id' => $permissionType->id,
                        ]);
                    }
                }

                return $invitation;
            });

            /*
             * هنا لاحقًا:
             * Send SMS / Email notification
             *
             * invitation URL:
             * /family/invitations/{token}
             */
            $invitationUrl = env('APP_URL') . '/family/invitation/' . $plainToken;

            $data =[
                'invitation_id' => $invitation->id,
                'status' => $invitation->status,
                'expires_at' => $invitation->expires_at,
                'invitation_url' => $invitationUrl,
            ];



            return ApiActions::generateResponse($data,'Family_invitation_sent_successfully');
        }catch(\Exception $e){
            return ApiActions::generateResponse(null, $e->getMessage(), ResponseCode::VALIDATION_ERROR);

        }



    }


    #[OA\Get(
        path: "/api/v1/user/family/invitation/{token}",
        operationId: "getFamilyInvitation",
        summary: "Get family invitation details",
        description: "Retrieve safe public information about a family invitation using its invitation token.",
        tags: ["Family Invitations"],
        security: [["api_key" => []]],
        parameters: [
            new OA\Parameter(
                name: "token",
                description: "Invitation token",
                in: "path",
                required: true,
               example: "0f36055d230a3098d86048b462f7c79d0a6ebda2cb963c1e12eb02c3e9aa0f8e",
               schema: new OA\Schema(
                    type: "string",
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Invitation retrieved successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Invitation retrieved successfully."
                        ),
                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/FamilyInvitation"
                        )
                    ],
                    type: "object"
                )
            ),

            new OA\Response(
                response: 404,
                description: "Invalid invitation token",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Invalid or expired invitation."
                        )
                    ],
                    type: "object"
                )
            ),

            new OA\Response(
                response: 422,
                description: "Invitation is no longer available",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "This invitation is no longer available."
                        )
                    ],
                    type: "object"
                )
            )
        ]
    )]
    public function showInvitation(string $token)
    {
//        return [
//            'token' => $token,
//            'length' => strlen($token),
//            'hash' => hash('sha256', $token),
//        ];

        $invitation = FamilyInvitation::with(['patient.user:id,name'])
                       ->where('token_hash','=', hash('sha256', $token))
                       ->first();

        if (!$invitation) {
            return ApiActions::generateResponse(null, 'Invalid_or_expired_invitation', ResponseCode::NOT_FOUND);
        }

        if ($invitation->status !== FamilyInvitationStatus::PENDING) {
            return ApiActions::generateResponse(null, 'This_invitation_is_no_longer_available', ResponseCode::VALIDATION_ERROR);

        }

        if ($invitation->expires_at && $invitation->expires_at->isPast()) {
            $invitation->update([
                'status' => FamilyInvitationStatus::EXPIRED,
            ]);

            return ApiActions::generateResponse(null, 'This_invitation_has_expired', ResponseCode::VALIDATION_ERROR);
        }

        $invitation = FamilyInvitationResource::make($invitation);
        return ApiActions::generateResponse($invitation);

    }


    #[OA\Post(
        path: "/api/v1/user/family/invitations/{token}/register",
        operationId: "registerFamilyInvitation",
        summary: "Register as a family member",
        description: "Create a new family account and accept a pending family invitation.",
        tags: ["Family Invitations"],
        security: [["api_key" => []]],
        parameters: [
            new OA\Parameter(
                name: "token",
                description: "Family invitation token",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "string",
                    example: "AbCdEf123456789..."
                )
            )
        ],

        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: "#/components/schemas/FamilyMemberRegister"
            )
        ),

        responses: [
            new OA\Response(
                response: 201,
                description: "Family account created and invitation accepted",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Family account created and invitation accepted successfully."
                        ),
                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "user",
                                    type: "object",
                                    properties: [
                                        new OA\Property(
                                            property: "id",
                                            type: "integer",
                                            example: 25
                                        ),
                                        new OA\Property(
                                            property: "name",
                                            type: "string",
                                            example: "Sara Ahmed"
                                        ),
                                        new OA\Property(
                                            property: "mobile",
                                            type: "string",
                                            example: "059XXXXXXX"
                                        ),
                                        new OA\Property(
                                            property: "role",
                                            type: "string",
                                            example: "family"
                                        )
                                    ]
                                ),
                                new OA\Property(
                                    property: "token",
                                    type: "string",
                                    example: "1|abcdefghijklmnopqrstuvwxyz..."
                                )
                            ]
                        )
                    ],
                    type: "object"
                )
            ),

            new OA\Response(
                response: 404,
                description: "Invalid invitation",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Invalid or expired invitation."
                        )
                    ],
                    type: "object"
                )
            ),

            new OA\Response(
                response: 409,
                description: "Mobile number already registered",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "An account already exists with this mobile number. Please login."
                        )
                    ],
                    type: "object"
                )
            ),

            new OA\Response(
                response: 422,
                description: "Validation error or invitation unavailable"
            )
        ]
    )]
    public function register(FamilyMemberRegisterRequest $request, string $token, FamilyInvitationService $familyInvitationService)
    {

        $invitation = FamilyInvitation::with(['patient.user:id,name', 'permissions.permissionType',])
                                      ->where('token_hash', hash('sha256', $token))
                                      ->first();

        if (!$invitation) {
            return ApiActions::generateResponse(null, 'Invalid_or_expired_invitation', ResponseCode::NOT_FOUND);
        }

        if ($invitation->status !== FamilyInvitationStatus::PENDING) {
            return ApiActions::generateResponse(null, 'This_invitation_is_no_longer_available', ResponseCode::VALIDATION_ERROR);
        }

        if ($invitation->expires_at && $invitation->expires_at->isPast()) {
            $invitation->update(['status' => FamilyInvitationStatus::EXPIRED,]);
            return ApiActions::generateResponse(null, 'This_invitation_has_expired', ResponseCode::VALIDATION_ERROR);
        }

        /*
         * The mobile number must come from the invitation.
         * The user must not be able to change it during registration.
         */
        if ($request->mobile !== $invitation->mobile) {
            return ApiActions::generateResponse(null, 'The_mobile_number_does_not_match_the_invitation', ResponseCode::VALIDATION_ERROR);
        }

        /*
         * The invited mobile must not already have an account.
         */
        if (User::where('mobile', $invitation->mobile)->exists()) {
            return ApiActions::generateResponse(null, 'An_account_already_exists_with_this_mobile_number_Please_login', ResponseCode::CONFLICT_ERROR);
        }

        $result = $familyInvitationService->register($invitation, $request->name, $request->password);

        $data['user']  = UserResource::make($result['user']);


        return ApiActions::generateResponse($data,'Family_account_created_and_invitation_accepted_successfully');

    }



    #[OA\Post(
        path: "/api/v1/user/family/invitations/{token}/accept",
        operationId: "acceptFamilyInvitation",
        summary: "Accept family invitation",
        description: "Accept a pending family invitation for an existing family account.",
        security: [["api_key" => []]],
        tags: ["Family Invitations"],
        parameters: [
            new OA\Parameter(
                name: "token",
                description: "Family invitation token",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "string",
                    example: "AbCdEf123456789..."
                )
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Invitation accepted successfully",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Family invitation accepted successfully."
                        ),
                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "patient_id",
                                    type: "integer",
                                    example: 7
                                ),
                                new OA\Property(
                                    property: "family_member_id",
                                    type: "integer",
                                    example: 10
                                ),
                                new OA\Property(
                                    property: "relationship",
                                    type: "string",
                                    example: "mother"
                                )
                            ]
                        )
                    ]
                )
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),

            new OA\Response(
                response: 403,
                description: "User is not a family member",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Only family accounts can accept family invitations."
                        )
                    ]
                )
            ),

            new OA\Response(
                response: 404,
                description: "Invalid invitation",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Invalid or expired invitation."
                        )
                    ]
                )
            ),

            new OA\Response(
                response: 409,
                description: "Invitation already accepted or relationship already exists",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "This invitation has already been accepted."
                        )
                    ]
                )
            ),

            new OA\Response(
                response: 422,
                description: "Invitation expired or mobile does not match",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "The mobile number does not match the invitation."
                        )
                    ]
                )
            )
        ]
    )]
    public function accept(Request $request, string $token,FamilyInvitationService $familyInvitationService)
    {
        $user = $request->user();


        /*
         * 1. Make sure the authenticated user is a family account.
         */
        if ($user->role !== 'family') {
            return ApiActions::generateResponse(null, 'Only_family_accounts_can_accept_family_invitations', ResponseCode::VALIDATION_ERROR);
        }

        /*
         * 2. Find invitation using hashed token.
         */
        $invitation = FamilyInvitation::with(['permissions',])
            ->where('token_hash', hash('sha256', $token))
            ->first();

        if (!$invitation) {
            return ApiActions::generateResponse(null, 'Invalid_or_expired_invitation', ResponseCode::NOT_FOUND);
        }
        /*
        * 3. Invitation must still be pending.
        */
        if ($invitation->status !== FamilyInvitationStatus::PENDING) {
            return ApiActions::generateResponse(null, 'This_invitation_is_no_longer_available', ResponseCode::VALIDATION_ERROR);
        }

        /*
         * 4. Check expiration.
         */
        if ($invitation->expires_at && $invitation->expires_at->isPast()) {
            $invitation->update(['status' => FamilyInvitationStatus::EXPIRED,]);
            return ApiActions::generateResponse(null, 'This_invitation_has_expired', ResponseCode::VALIDATION_ERROR);
        }

        /*
         * 5. Make sure the logged-in user's mobile
         * matches the mobile used in the invitation.
         */
        if ($user->mobile !== $invitation->mobile) {
            return ApiActions::generateResponse(null, 'The_mobile_number_does_not_match_the_invitation', ResponseCode::VALIDATION_ERROR);
        }

        /*
          * Accept invitation.
         */
        $patientFamilyMember = $familyInvitationService->accept($invitation, $user);

        return ApiActions::generateResponse($patientFamilyMember);

    }


}
