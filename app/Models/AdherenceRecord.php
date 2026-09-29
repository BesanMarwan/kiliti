<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdherenceRecord extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'dialysis_score' => 'decimal:2',
            'medication_score' => 'decimal:2',
            'fluid_score' => 'decimal:2',
            'measurement_score' => 'decimal:2',
            'overall_score' => 'decimal:2',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
