<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicationLog extends Model
{
    use HasFactory;

    protected $guarded =[];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'taken_at' => 'datetime',
            'snoozed_until' => 'datetime',
        ];
    }

    public function patientMedication()
    {
        return $this->belongsTo(PatientMedication::class);
    }
}
