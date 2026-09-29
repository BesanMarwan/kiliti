<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicationAlert extends Model
{
    protected $fillable = [
        'patient_medication_id',
        'scheduled_at',
        'type',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function patientMedication(): BelongsTo
    {
        return $this->belongsTo(PatientMedication::class);
    }
}
