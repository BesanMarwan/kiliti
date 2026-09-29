<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMedication extends Model
{
    use HasFactory;
    public $guarded =[];
    protected $appends = [
        'next_dose_time',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'reminder_times' => 'array',
            'reminder_enabled' => 'boolean',
        ];
    }


   public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
    public function alerts(): HasMany
    {
        return $this->hasMany(MedicationAlert::class);
    }

    public function routeObj()
    {
        return $this->belongsTo(GeneralData::class,'route');
    }


    public function logs()
    {
        return $this->hasMany(MedicationLog::class);
    }


    public function getNextDoseTimeAttribute()
    {

        if (!$this->reminder_enabled || empty($this->reminder_times)) {
            return null;
        }

        $now = now('Asia/Gaza');

        if ($this->status !== 'active' || !$this->reminder_enabled || empty($this->reminder_times)) {
            return null;
        }

        foreach ($this->reminder_times as $time) {
            $doseTime = $now->copy()->setTimeFromTimeString($time);

            if ($doseTime->isAfter($now)) {
                return $doseTime;
            }
        }

        return $now->copy()->addDay()->setTimeFromTimeString($this->reminder_times[0]);
    }
}
