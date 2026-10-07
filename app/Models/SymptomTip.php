<?php

namespace App\Models;

use App\Traits\HasSearchable;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SymptomTip extends Model
{
    use HasFactory,HasTranslations,HasSearchable;

    protected $guarded = [];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public $translatable = ['title', 'content'];


    public function symptom(): BelongsTo
    {
        return $this->belongsTo(Symptom::class, 'symptom_id');
    }
}
