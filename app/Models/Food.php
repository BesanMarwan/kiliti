<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Food extends Model
{
    use HasFactory,HasTranslations;

    protected $guarded = [];

    public $translatable = ['name'];
    protected $table = 'foods';

    protected $casts = [
        'serving_amount' => 'float',
        'potassium_mg' => 'float',
        'phosphorus_mg' => 'float',
        'sodium_mg' => 'float',
    ];

    public function aliases(): HasMany
    {
        return $this->hasMany(FoodAlias::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(FoodCategory::class, 'food_category_id');
    }

}

