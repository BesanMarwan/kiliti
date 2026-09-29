<?php

namespace App\Services;

use App\Models\PatientMedication;
use App\Models\MedicationLog;
use Carbon\Carbon;

class MedicationScheduleService
{
    public function generateForPeriod(PatientMedication $patientMedication, Carbon $from, Carbon $to): void {
        if (!$this->canGenerate($patientMedication)) {
            return;
        }

        $times = $patientMedication->reminder_times ?? [];

        if (empty($times)) {
            return;
        }

        $currentDate = $from->copy()->startOfDay();

        while ($currentDate->lte($to)) {

            foreach ($times as $time) {

                $scheduledAt = $currentDate->copy()->setTimeFromTimeString($time);

                if (!$this->isValidSchedule($patientMedication, $scheduledAt)) {
                    continue;
                }

                MedicationLog::firstOrCreate(
                    [
                        'patient_medication_id' => $patientMedication->id,
                        'scheduled_at' => $scheduledAt,
                    ],
                    [
                        'status' => 'pending',
                    ]
                );
            }

            $currentDate->addDay();
        }
    }

    protected function canGenerate(PatientMedication $patientMedication): bool {
        return $patientMedication->status === 'active'
               && $patientMedication->reminder_enabled
               && !empty($patientMedication->reminder_times);
    }

    protected function isValidSchedule(PatientMedication $patientMedication, Carbon $scheduledAt): bool {
        if ($patientMedication->start_date && $scheduledAt->lt($patientMedication->start_date->startOfDay())) {
            return false;
        }

        if ($patientMedication->end_date && $scheduledAt->gt($patientMedication->end_date->endOfDay())) {
            return false;
        }

        return true;
    }
}
