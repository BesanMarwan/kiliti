<?php

namespace App\Services\Food;

use App\Models\Food;

class FoodGuidanceService
{
    public function __construct(
        protected FoodNutrientLevelService $nutrientLevelService,
        protected FoodAlternativeService $alternativeService
    ) {
    }

    public function build(Food $food): array
    {
        return [
            'food' => [
                'id' => $food->id,
                'name' => $food->name,
                'name_en' => $food->name_en,

                'serving' => [
                    'amount' => $food->serving_amount,
                    'unit' => $food->serving_unit,
                    'description' => $food->serving_description,
                ],
            ],

            'nutrients' => [
                'potassium' => $this->nutrient(
                    'potassium',
                    $food->potassium_mg
                ),

                'phosphorus' => $this->nutrient(
                    'phosphorus',
                    $food->phosphorus_mg
                ),

                'sodium' => $this->nutrient(
                    'sodium',
                    $food->sodium_mg
                ),
            ],

            'guidance' => $food->general_guidance,

            'alternatives' =>
                $this->alternativeService
                    ->findAlternatives($food)
                    ->values()
                    ->all(),
        ];
    }

    private function nutrient(
        string $type,
        ?float $value
    ): ?array {
        if ($value === null) {
            return null;
        }

        return [
            'value' => $value,
            'unit' => 'mg',

            'level' =>
                $this->nutrientLevelService
                    ->getLevel($type, $value),
        ];
    }
}
