<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Actions\ApiActions;
use App\Constants\ResponseCode;
use App\Enums\FamilyRelationship;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\General\RateRequest;
use App\Http\Resources\General\GeneralDataResource;
use App\Http\Resources\General\RateResource;
use App\Http\Resources\User\CenterResource;
use App\Models\ApplicationRate;
use App\Models\DialysisCenter;
use App\Models\GeneralData;
use App\Models\Settings;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Base General API swagger documentation",
    version: "1.0.0",
    description: "Base General API Documentation",
    termsOfService: "http://swagger.io/terms/",
    contact: new OA\Contact(
        email: "besanmarwan2000@gmail.com"
    ),
    license: new OA\License(
        name: "Apache 2.0",
        url: "http://www.apache.org/licenses/LICENSE-2.0.html"
    )
)]
class GeneralController extends Controller
{
    #[OA\Get(
        path: "/api/v1/app/get_configuration",
        operationId: "getConfiguration",
        tags: ["GeneralApiSection"],
        summary: "Get configrations API",
        description: "Get configrations service",

        parameters: [
            new OA\Parameter(
                parameter: "language",
                ref: "#/components/parameters/language"
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "OK",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/GeneralDataResource"
                )
            )
        ]
    )]
    public function get_configuration()
    {

        $configurations = Settings::active()->pluck('value', 'name');

        return ApiActions::generateResponse(compact('configurations'));
    }



    #[OA\Get(
        path: "/api/v1/app/get_dialysis_centers",
        operationId: "get_dialysis_centers",
        tags: ["GeneralApiSection"],
        summary: "Get Dialysis Centers API",
        description: "Get Dialysis Centers Objects",

        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            )
            , new OA\Parameter(
                parameter: "name",
                name: "name",
                description: "search of name center",
                required: false,
                in: "query",

                schema: new OA\Schema(
                    type: "string"
                )
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "successful operation with status = true "
            )
        ]
    )]
    public function get_dialysis_centers(Request $request)
    {
        $centers = DialysisCenter::active()->filter($request)->select('id','name')->whereHas('doctors')->get();
        $centers = CenterResource::collection($centers);

        return ApiActions::generateResponse(compact('centers'));
    }


    #[OA\Post(
        path: "/api/v1/app/rate",
        operationId: "rateApplication",
        tags: ["GeneralApiSection"],
        summary: "User Rate Application API",
        description: "User Rate Application  returns rate object",
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    ref: "#/components/schemas/ApplicationRate"
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
                    ref: "#/components/schemas/RateResource"
                )
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function rateApplication(RateRequest $request)
    {
        $user = \auth()->user();
        if($user->rate){
            return ApiActions::generateResponse(null,'application_rated_before',ResponseCode::VALIDATION_ERROR);
        }

        $rate_obj = ApplicationRate::create([
              'rate'    => $request->rate,
              'comment' => $request->comment,
              'user_id' => $user->id
         ]);

        $rate_obj = RateResource::make($rate_obj);
        return ApiActions::generateResponse(compact('rate_obj'));

    }

    #[OA\Get(
        path: "/api/v1/app/family-relationships",
        operationId: "getFamilyRelationships",
        summary: "Get family relationships",
        description: "Returns the available family relationship types.",
        tags: ["GeneralApiSection"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Family relationships retrieved successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Family relationships retrieved successfully."
                        ),
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(
                                        property: "value",
                                        type: "string",
                                        example: "mother"
                                    ),
                                    new OA\Property(
                                        property: "label_ar",
                                        type: "string",
                                        example: "الأم"
                                    ),
                                    new OA\Property(
                                        property: "label_en",
                                        type: "string",
                                        example: "Mother"
                                    ),
                                ],
                                type: "object"
                            )
                        ),
                    ],
                    type: "object"
                )
            ),
        ]
    )]
    public function familyRelationships()
    {
        $relationships = collect(FamilyRelationship::cases())
            ->map(fn (FamilyRelationship $relationship) => [
                'value' => $relationship->value,
                'label_ar' => $relationship->labelAr(),
                'label_en' => $relationship->labelEn(),
            ])
            ->values();

        return ApiActions::generateResponse($relationships);
    }


    /**

     *     @OA\Parameter(
     *          name="",
     *          description="item_type one of:dialysis_session_issue,consultation_type",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\Parameter(ref="#/components/parameters/language"),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *        @OA\JsonContent(ref="#/components/schemas/GeneralDataResource"),
     *         ),
     * )
     */

    #[OA\Get(
        path: "/api/v1/app/get_gen_items/{item_type}",
        operationId: "get_gen_items",
        summary: "Get general items API",
        description: "Get general items service the item_type can be one of:dialysis_session_issue,consultation_type",
        tags: ["GeneralApiSection"],
        parameters: [
            new OA\Parameter(
                name: "item_type",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "string"
                ),
                example: "consultation_type"
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "General Items Objects retrieved successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/GeneralDataResource"
                        )
                    ]
                )
            ),
        ]
    )]
    public function get_gen_items($item_type)
    {
        $item_cat = GeneralData::with('children')->where('uuid',$item_type)->firstOrFail();
        $items    = GeneralDataResource::collection($item_cat->children);
        $item_cat = GeneralDataResource::make($item_cat);
        return ApiActions::generateResponse(compact('item_cat','items'));
    }




//
//    #[OA\Get(
//        path: "/api/v1/app/get_doctors",
//        operationId: "get_doctors",
//        tags: ["GeneralApiSection"],
//        summary: "Get all Doctors API",
//        description: "Get Dialysis all Doctors  Objects",
//
//        parameters: [
//            new OA\Parameter(
//                ref: "#/components/parameters/language"
//            ),
//            new OA\Parameter(
//                parameter: "name",
//                name: "name",
//                description: "search of name center",
//                required: false,
//                in: "query",
//
//                schema: new OA\Schema(
//                    type: "string"
//                )
//            ),
//            new OA\Parameter(
//                parameter: "name",
//                name: "name",
//                description: "search of name center",
//                required: false,
//                in: "query",
//
//                schema: new OA\Schema(
//                    type: "string"
//                )
//            )
//        ],
//
//        responses: [
//            new OA\Response(
//                response: 200,
//                description: "successful operation with status = true "
//            )
//        ]
//    )]
//    public function get_doctors(Request $request)
//    {
//        $centers = DialysisCenter::active()->filter($request)->select('id','name')->whereHas('doctors')->get();
//        $centers = CenterResource::collection($centers);
//
//        return ApiActions::generateResponse(compact('centers'));
//    }


}
