<?php

namespace App\Services\Food;

use App\Models\Food;
use Illuminate\Support\Collection;

class FoodAlternativeService
{
//    public function findAlternatives(
//        Food $food,
//        int $limit = 3
//    ): Collection {
//        $query = Food::query()
//            ->where('status', 'enabled')
//            ->whereKeyNot($food->id);
//
//        /*
//         * Prefer foods from the same category.
//         */
//        if ($food->category) {
//            $query->where('category', $food->category);
//        }
//
//        /*
//         * Prefer foods with lower potassium.
//         */
//        if ($food->potassium_mg !== null) {
//            $query->where(function ($q) use ($food) {
//                $q->whereNull('potassium_mg')
//                    ->orWhere(
//                        'potassium_mg',
//                        '<',
//                        $food->potassium_mg
//                    );
//            });
//        }
//
//        return $query
//            ->orderByRaw(
//                'CASE
//                    WHEN potassium_mg IS NULL THEN 1
//                    ELSE 0
//                 END'
//            )
//            ->orderBy('potassium_mg')
//            ->limit($limit)
//            ->get();
//    }

    private function score(
        Food $original,
        Food $candidate
    ): int {
        $score = 0;

        if (
            $original->potassium_mg !== null &&
            $candidate->potassium_mg !== null &&
            $candidate->potassium_mg < $original->potassium_mg
        ) {
            $score += 40;
        }

        if (
            $original->phosphorus_mg !== null &&
            $candidate->phosphorus_mg !== null &&
            $candidate->phosphorus_mg < $original->phosphorus_mg
        ) {
            $score += 25;
        }

        if (
            $original->sodium_mg !== null &&
            $candidate->sodium_mg !== null &&
            $candidate->sodium_mg < $original->sodium_mg
        ) {
            $score += 20;
        }

        if (
            $original->category &&
            $candidate->category === $original->category
        ) {
            $score += 15;
        }

        return $score;
    }

    public function findAlternatives(
        Food $food,
        int $limit = 3
    ): Collection {
        $candidates = Food::query()
            ->where('status', 'enabled')
            ->whereKeyNot($food->id)
            ->get();

        return $candidates
            ->map(function (Food $candidate) use ($food) {
                return [
                    'food' => $candidate,
                    'score' => $this->score(
                        $food,
                        $candidate
                    ),
                ];
            })
            ->sortByDesc('score')
            ->take($limit)
            ->values()
            ->map(function ($item) {
                $food = $item['food'];

                return [
                    'id' => $food->id,
                    'name' => $food->name,
                    'name_en' => $food->getTranslation('name','en'),
                    'reason' => $this->reason(
                        $food,
                        $item['score']
                    ),
                ];
            });
    }

    private function reason(Food $food, int $score): string {
        return 'بديل مقترح بناءً على القيم الغذائية المتوفرة.';
    }
}
