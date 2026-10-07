<?php

namespace App\Services;

use App\Contracts\FoodProviderInterface;
use App\Services\Food\FoodDatabaseService;
use App\Services\Food\FoodGuidanceService;

class FoodAssistantService
{
    public function __construct(
        protected FoodProviderInterface $foodProvider,
        protected FoodDatabaseService $foodDatabaseService,
        protected FoodGuidanceService $foodGuidanceService
    ) {
    }

    public function search(string $query): array
    {
        // 1. Try AI identification
        $foodName = $this->foodProvider->identify($query);

        // 2. Try database using AI result
        if ($foodName) {
            $food = $this->foodDatabaseService->find($foodName);

            if ($food) {
                return [
                    'query' => $query,
                    ...$this->foodGuidanceService->build($food),
                ];
            }
        }

        // 3. Fallback: search original user query
        $food = $this->foodDatabaseService->find($query);

        if ($food) {
            return [
                'query' => $query,
                ...$this->foodGuidanceService->build($food),
            ];
        }

        // 4. Nothing found
        return $this->emptyResult($query);
    }
    private function emptyResult(string $query): array
    {
        return [
            'query' => $query,
            'food' => null,

            'nutrients' => [
                'potassium' => null,
                'phosphorus' => null,
                'sodium' => null,
            ],

            'guidance' => null,

            'alternatives' => [],
        ];
    }
}
