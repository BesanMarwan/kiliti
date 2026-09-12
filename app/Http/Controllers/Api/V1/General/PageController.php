<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Actions\ApiActions;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PageController extends Controller
{
    #[OA\Get(
        path: "/api/v1/app/page/{page_id}",
        operationId: "pages",
        tags: ["PagesApiSection"],
        summary: "Get Static Pages API",
        description: "Get Pages service : Conditions id = 1 or Privacy Policy id = 2 or Feed back id = 3",

        parameters: [

            new OA\Parameter(
                name: "page_id",
                description: "page_id",
                required: true,
                in: "path",

                schema: new OA\Schema(
                    type: "string"
                )
            ),

            new OA\Parameter(
                ref: "#/components/parameters/language"
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "successful operation with status = true"
            )
        ]
    )]
    public function get_page(Request $request, $page_id)
    {
        $page = Page::where('id', $page_id)->firstOrFail();

        return ApiActions::generateResponse(compact('page'));
    }
}
