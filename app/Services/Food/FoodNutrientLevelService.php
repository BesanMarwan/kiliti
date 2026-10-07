<?php

namespace App\Services\Food;

use App\Models\FoodNutrientRule;

class FoodNutrientLevelService
{
    public function getLevel(string $nutrient, ?float $value): string {
        if ($value === null) {
            return 'unknown';
        }

        $rule = FoodNutrientRule::query()
            ->where('nutrient', $nutrient)
            ->where('status', true)
            ->first();

        if (!$rule) {
            return 'unknown';
        }

        return match (true) {
            $value <= $rule->low_max => 'low',

            $value <= $rule->moderate_max => 'moderate',

            default => 'high',
        };
    }
}
