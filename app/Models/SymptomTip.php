<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SymptomTip extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function symptom(): BelongsTo
    {
        return $this->belongsTo(Symptom::class, 'symptom_id');
    }
}
