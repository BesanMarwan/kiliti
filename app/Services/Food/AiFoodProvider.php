<?php

namespace App\Services\Food;

use App\Contracts\FoodProviderInterface;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use Throwable;

class AiFoodProvider implements FoodProviderInterface
{
    public function identify(string $query): ?string
    {
        try {
            $response = OpenAI::responses()->create([
                'model' => config('services.openai.model', 'gpt-5'),

                'input' => [
                    [
                        'role' => 'system',
                        'content' => <<<'PROMPT'
You identify food items from user queries for a kidney
patient food information application.

Your ONLY task is to identify the food being asked about.

Rules:
- Return only the common English food name.
- Do not provide nutrition information.
- Do not provide medical advice.
- Do not invent a food.
- If no food can be identified, return null.
- If the user asks a question about a food, extract the food name.
- Prefer the most specific food that is clearly identified.

Examples:

"هل الموز مناسب؟"
banana

"كم يحتوي الأرز الأبيض؟"
white rice

"هل أستطيع أكل الدجاج المشوي؟"
grilled chicken

"ما كمية البوتاسيوم في التفاح؟"
apple
PROMPT,
                    ],
                    [
                        'role' => 'user',
                        'content' => $query,
                    ],
                ],

                'text' => [
                    'format' => [
                        'type' => 'json_schema',
                        'name' => 'food_identification',
                        'strict' => true,
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'food_name' => [
                                    'type' => [
                                        'string',
                                        'null',
                                    ],
                                ],
                            ],
                            'required' => [
                                'food_name',
                            ],
                            'additionalProperties' => false,
                        ],
                    ],
                ],
            ]);

            $data = json_decode(
                $response->outputText,
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            return $data['food_name'] ?? null;

        } catch (Throwable $e) {

            Log::error('Food identification failed.', [
                'query' => $query,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }
}
