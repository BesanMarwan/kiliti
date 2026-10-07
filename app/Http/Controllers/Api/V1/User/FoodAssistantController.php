<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\ApiActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\FoodAssistantRequest;
use App\Http\Resources\User\FoodAssistantResource;
use App\Services\FoodAssistantService;
use OpenApi\Attributes as OA;

class FoodAssistantController extends Controller
{
    public function __construct(protected FoodAssistantService $foodAssistantService) {
    }


#[OA\Get(
    path: "/api/v1/user/food-assistant/search",
    summary: "Search food information",
    description: "Search for a food using a food name or natural language query. The system identifies the food, retrieves verified nutrition data from the food database, calculates nutrient levels, and returns general guidance and alternatives.",
    security: [
        ["api_key" => []]
    ],
    tags: ["Food Assistant"],
    parameters: [
        new OA\Parameter(
            name: "search",
            description: "Food name or natural language query",
            required: true,
            in: "query",
            example: "موز",
            schema: new OA\Schema(
                type: "string",
                minLength: 2,
                maxLength: 500
            )
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Food information retrieved successfully",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "query",
                        type: "string",
                        example: "موز"
                    ),

                    new OA\Property(
                        property: "food",
                        type: "object",
                        nullable: true,
                        properties: [
                            new OA\Property(
                                property: "id",
                                type: "integer",
                                example: 1
                            ),
                            new OA\Property(
                                property: "name",
                                type: "string",
                                example: "موز"
                            ),
                            new OA\Property(
                                property: "name_en",
                                type: "string",
                                example: "banana"
                            ),

                            new OA\Property(
                                property: "serving",
                                type: "object",
                                properties: [
                                    new OA\Property(
                                        property: "amount",
                                        type: "number",
                                        format: "float",
                                        example: 118
                                    ),
                                    new OA\Property(
                                        property: "unit",
                                        type: "string",
                                        example: "g"
                                    ),
                                    new OA\Property(
                                        property: "description",
                                        type: "string",
                                        example: "حبة متوسطة"
                                    ),
                                ]
                            ),
                        ]
                    ),

                    new OA\Property(
                        property: "nutrients",
                        type: "object",
                        properties: [
                            new OA\Property(
                                property: "potassium",
                                type: "object",
                                nullable: true,
                                properties: [
                                    new OA\Property(
                                        property: "value",
                                        type: "number",
                                        format: "float",
                                        example: 422
                                    ),
                                    new OA\Property(
                                        property: "unit",
                                        type: "string",
                                        example: "mg"
                                    ),
                                    new OA\Property(
                                        property: "level",
                                        type: "string",
                                        example: "high"
                                    ),
                                ]
                            ),

                            new OA\Property(
                                property: "phosphorus",
                                type: "object",
                                nullable: true,
                                properties: [
                                    new OA\Property(
                                        property: "value",
                                        type: "number",
                                        format: "float",
                                        example: 26
                                    ),
                                    new OA\Property(
                                        property: "unit",
                                        type: "string",
                                        example: "mg"
                                    ),
                                    new OA\Property(
                                        property: "level",
                                        type: "string",
                                        example: "low"
                                    ),
                                ]
                            ),

                            new OA\Property(
                                property: "sodium",
                                type: "object",
                                nullable: true,
                                properties: [
                                    new OA\Property(
                                        property: "value",
                                        type: "number",
                                        format: "float",
                                        example: 1
                                    ),
                                    new OA\Property(
                                        property: "unit",
                                        type: "string",
                                        example: "mg"
                                    ),
                                    new OA\Property(
                                        property: "level",
                                        type: "string",
                                        example: "low"
                                    ),
                                ]
                            ),
                        ]
                    ),

                    new OA\Property(
                        property: "guidance",
                        type: "string",
                        nullable: true,
                        example: "الموز يحتوي على كمية مرتفعة نسبيًا من البوتاسيوم."
                    ),

                    new OA\Property(
                        property: "alternatives",
                        type: "array",
                        items: new OA\Items(
                            type: "object"
                        )
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
            description: "User is not a patient"
        ),

        new OA\Response(
            response: 422,
            description: "Validation error"
        ),

        new OA\Response(
            response: 404,
            description: "Food not found"
        ),
    ]
)]
    public function search(FoodAssistantRequest $request)
    {
//        $result = $this->foodAssistantService->search($request->validated('search'));
        return $result = app(\App\Actions\CheckFoodWithAIAction::class)->execute(auth()->user()->patient, $request->search);
        return ApiActions::generateResponse(new FoodAssistantResource($result));
    }
}
