<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\ApiActions;
use App\Constants\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\NotificationResource;
use App\Notifications\FcmLegacyNotification;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class NotificationController extends Controller
{
    #[OA\Post(
        path: "/api/v1/user/update_fcm_token",
        operationId: "Update_fcm_token",
        tags: ["NotificationsApiSection"],
        summary: "update FCM token",
        description: "Update fcm token for not authenticated device (no user)",
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    required: ["token"],
                    properties: [
                        new OA\Property(
                            property: "token",
                            description: "FCM token",
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
                description: "successful operation with status = true and user object"
            ),

            new OA\Response(
                response: 422,
                description: "status = false : unauthorized user"
            )
        ]
    )]
    public function updateFcmToken(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'token' => 'required',
        ]);

        ApiActions::ChangeUserDevice($request);

        return ApiActions::generateResponse(null);
    }

    #[OA\Post(
        path: "/api/v1/user/update_user_fcm_token",
        operationId: "updateUserFcmToken",
        tags: ["NotificationsApiSection"],
        summary: "User update FCM token",
        description: "Update fcm token for authenticated user (login required)",
        security: [["api_key" => []]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    required: ["token"],
                    properties: [
                        new OA\Property(
                            property: "token",
                            description: "FCM token",
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
                description: "successful operation with status = true and user object"
            ),

            new OA\Response(
                response: 422,
                description: "status = false : unauthorized user"
            )
        ]
    )]
    public function updateUserFcmToken(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'token' => 'required',
        ]);

        ApiActions::ChangeUserDevice($request);

        return ApiActions::generateResponse(null);
    }

    #[OA\Get(
        path: "/api/v1/user/get_user_notifications",
        operationId: "getUserNotifications",
        tags: ["NotificationsApiSection"],
        summary: "Get user notifications API",
        description: "Get user notifications service",
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
    public function getUserNotifications(Request $request)
    {
        $user = $request->user();

        $notifications = $user->notifications()->orderByDesc('id')->get();
        if (!$notifications) {
            return ApiActions::generateResponse(null, 'notifications_not_found', ResponseCode::NOT_FOUND);
        }

        $notifications = NotificationResource::collection($notifications);

        return ApiActions::generateResponse(compact('notifications'));
    }

    #[OA\Post(
        path: "/api/v1/user/delete_notification",
        operationId: "DeleteUserNotification",
        tags: ["NotificationsApiSection"],
        summary: "delete user notification using notification id",
        description: "delete user notification using notification id service",
        security: [["api_key" => []]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    required: ["notification_id"],
                    properties: [
                        new OA\Property(
                            property: "notification_id",
                            description: "deletable notification id",
                            type: "number"
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
                description: "successful operation with status = true along with message"
            ),

            new OA\Response(
                response: 422,
                description: "notification not found"
            )
        ]
    )]
    public function DeleteUserNotification(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|exists:fcm_notifications,id',
        ]);
        $user = $request->user();

        $notification = $user->notifications()->findOrFail($request->notification_id);

        $notification->delete();

        $notifications = $user->notifications()->orderByDesc('id')->get();
        if (!$notifications) {
            return ApiActions::generateResponse(null, 'notifications_not_found', ResponseCode::NOT_FOUND);
        }
        $notifications = NotificationResource::collection($notifications);

        return ApiActions::generateResponse(compact('notifications'));
    }
}
