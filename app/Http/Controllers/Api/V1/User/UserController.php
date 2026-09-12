<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\ApiActions;
use App\Constants\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\FamilyMemberResource;
use App\Http\Resources\User\UserResource;
use App\Rules\PasswordPolicy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    #[OA\Get(
        path: "/api/v1/user/me",
        operationId: "me",
        tags: ["UserApiSection"],
        summary: "me",
        description: "me",
        security: [["api_key" => []]],
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
    public function me()
    {
        $user = \auth()->user();

        $user = UserResource::make($user);

        return ApiActions::generateResponse(compact('user'));
    }


    #[OA\Post(
        path: "/api/v1/user/delete_me",
        operationId: "delete_me",
        tags: ["UserApiSection"],
        summary: "delete_me",
        description: "delete_me",
        security: [["api_key" => []]],
        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "successful operation with status = true along with message"
            ),

            new OA\Response(
                response: 422,
                description: "notification not found"
            )
        ]
    )]
    public function delete_me(Request $request)
    {
        $user = \auth()->user();
        $user->delete();
        return ApiActions::generateResponse();
    }

    #[OA\Post(
        path: "/api/v1/user/change_password",
        operationId: "changePassword",
        tags: ["AuthanticationApiSection"],
        summary: "change authenticated user password API",
        description: "change authenticated user password service",
        security: [["api_key" => []]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    schema: "change_password",
                    required: [
                        "old_password",
                        "new_password",
                        "new_password_confirmation"
                    ],
                    properties: [
                        new OA\Property(
                            property: "old_password",
                            description: "Account old password",
                            type: "string"
                        ),

                        new OA\Property(
                            property: "new_password",
                            description: "Account new password should be at least 6 chars and different from old one",
                            type: "string"
                        ),

                        new OA\Property(
                            property: "new_password_confirmation",
                            description: "should be same as new_password",
                            type: "string"
                        )
                    ]
                )
            )
        ),
        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            )
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
                description: "old password wrong , new password same as old"
            )
        ]
    )]
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => ['required', new PasswordPolicy(), 'confirmed'],

        ]);
        $user = $request->user();
        if (Hash::check($request->old_password, $user->password)) {
            if (Hash::check($request->new_password, $user->password)) {
                return ApiActions::generateResponse(null, 'new_same_old_password', ResponseCode::VALIDATION_ERROR);
            } else {
                $user->password = Hash::make($request->new_password);

                Auth::user()->tokens->each(function ($token, $key) {
                    $token->delete();
                });
                $user->accessToken = $user->createToken('User_' . $user->id . '_' . Carbon::now()->toDateTimeString())->plainTextToken;
                $user->save();

                $user = UserResource::make($user);

                return ApiActions::generateResponse(compact('user'));
            }
        } else {
            return ApiActions::generateResponse(null, 'invalid_old_password', ResponseCode::VALIDATION_ERROR);
        }
    }


    #[OA\Get(
        path: "/api/v1/user/get_family_member",
        operationId: "getFamilyMember",
        tags: ["FamilyMemberApiSection"],
        summary: "getFamilyMember",
        description: "getFamilyMember",
        security: [["api_key" => []]],
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
    public function getFamilyMember()
    {
        $user           = \auth()->user();
        $family_members = FamilyMemberResource::collection($user->patient->familyMembers);
        return ApiActions::generateResponse(compact('family_members'));
    }


}
