<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodNutrientRule extends Model
{
    protected $guarded = [];

    protected $casts = [
        'low_max' => 'float',
        'moderate_max' => 'float',
        'status' => 'boolean',
    ];
}
