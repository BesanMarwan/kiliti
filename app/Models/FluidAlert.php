<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FluidAlert extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'date',
        'type',
        'consumed_ml',
        'limit_ml',
    ];

    protected $casts = [
        'date' => 'date',
        'consumed_ml' => 'float',
        'limit_ml' => 'float',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
