<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Actions\ApiActions;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\CenterResource;
use App\Models\City;
use App\Models\Contact;
use App\Models\Country;
use App\Models\DialysisCenter;
use App\Models\PaymentType;
use App\Models\Settings;
use App\Models\User;
use App\Rules\ValidMobile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
