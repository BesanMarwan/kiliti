<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAnalysisLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'analysis_type',
        'input_data',
        'result',
        'confidence',
    ];

    protected function casts(): array
    {
        return [
            'input_data' => 'array', // or json
            'result' => 'array',
            'confidence' => 'decimal:2',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
