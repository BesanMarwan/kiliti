<?php

namespace Database\Seeders;

use App\Models\FoodNutrientRule;
use Illuminate\Database\Seeder;

class FoodNutrientRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            [
                'nutrient' => 'potassium',
                'low_max' => 100,
                'moderate_max' => 300,
                'unit' => 'mg',
            ],

            [
                'nutrient' => 'phosphorus',
                'low_max' => 100,
                'moderate_max' => 300,
                'unit' => 'mg',
            ],

            [
                'nutrient' => 'sodium',
                'low_max' => 100,
                'moderate_max' => 300,
                'unit' => 'mg',
            ],
        ];

        foreach ($rules as $rule) {
            FoodNutrientRule::updateOrCreate(
                [
                    'nutrient' => $rule['nutrient'],
                ],
                $rule
            );
        }
    }
}
