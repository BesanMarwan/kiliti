<?php

namespace App\Services\Food;

use App\Models\Food;

class FoodDatabaseService
{
    public function find(string $foodName): ?Food
    {
        return Food::query()
            ->where('status', 'enabled')
            ->where(function ($query) use ($foodName) {

                $query
                    ->where('name->en', 'like', "%{$foodName}%")
                    ->orWhere('name->ar', 'like', "%{$foodName}%")
                    ->orWhereHas('aliases', function ($aliasQuery) use ($foodName) {
                        $aliasQuery->where(
                            'alias',
                            'like',
                            "%{$foodName}%"
                        );
                    });

            })
            ->first();
    }
}
