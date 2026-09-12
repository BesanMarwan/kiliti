<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Actions\ApiActions;
use App\Constants\ResponseCode;
use App\Http\Controllers\Controller;
use App\Jobs\OrderPaid;
use App\Jobs\SendAdminsNotification;
use App\Models\Bill;
use App\Models\Order;
use App\Models\OrderCar;
use App\Models\OrderExtendRequest;
use App\Models\OrderService;
use App\Models\OrderStatusLog;
use App\Models\OrderUpgradeRequest;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\UserPremiumRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    #[OA\Post(
        path: "/api/v1/app/confirm_payment",
        operationId: "confirm_payment",
        tags: ["PaymentApiSection"],
        summary: "Confirm Payment API",
        description: "Confirm Payment API",

        security: [
            ["api_key" => []]
        ],

        parameters: [
            new OA\Parameter(
                name: "language",
                description: "response language : ar for arabic || en for english",
                required: false,
                in: "header",

                schema: new OA\Schema(
                    type: "string"
                )
            )
        ],

        requestBody: new OA\RequestBody(
            required: true,

            content: new OA\MediaType(
                mediaType: "multipart/form-data",

                schema: new OA\Schema(
                    required: ["transaction_id", "amount_paid", "return_response"],
                    type: "object",

                    properties: [

                        new OA\Property(
                            property: "transaction_id",
                            description: "valid transaction_id",
                            type: "string"
                        ),

                        new OA\Property(
                            property: "amount_paid",
                            description: "amount paid from provider",
                            type: "number"
                        ),

                        new OA\Property(
                            property: "return_response",
                            description: "payment return response",
                            type: "string"
                        ),
                    ]
                )
            )
        ),

        responses: [
            new OA\Response(
                response: 200,
                description: "successful operation with status = true"
            )
        ]
    )]
    public function confirm_payment(Request $request)
    {
        $transaction = Transaction::where('transaction_id', $request->transaction_id)->firstOrFail();
        $obj = $transaction->payable;
        if ($transaction->status == 'new') {
            $transaction->is_paid = 1;
            $transaction->paid_at = Carbon::now();
            $transaction->payment_response = $request->return_response;
            $transaction->status = 'paid';
            $transaction->save();

            if ($obj instanceof UserPremiumRequest) {
                $obj->status='active';
                $profile=$obj->user_profile;
                $profile->is_premium=1;
                $profile->premium_start_date=$obj->start_date;
                $profile->premium_end_date=$obj->end_date;
                $profile->save();

            }

        } else {
            return ApiActions::generateResponse(null, 'no_transaction', ResponseCode::INTERNAL_ERROR);
        }

        return ApiActions::generateResponse();
    }
}
