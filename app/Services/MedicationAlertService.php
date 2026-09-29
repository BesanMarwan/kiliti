<?php

namespace App\Services;

use App\Jobs\SendUserNotification;
use App\Models\MedicationAlert;
use App\Models\MedicationLog;
use App\Models\PatientMedication;
use Carbon\Carbon;

class MedicationAlertService
{
    /**
     * Send upcoming medication reminders.
     */
    public function checkUpcoming(): void
    {
        $now = now();

        $from = $now->copy();
        $to = $now->copy()->addMinutes(15);

        $medications = PatientMedication::query()->with(['patient.user', 'medication',])
                                              ->where('status', 'active')
                                              ->where('reminder_enabled', true)
                                              ->where(function ($query) use ($now) {
                                                  $query->whereNull('start_date')
                                                      ->orWhereDate('start_date', '<=', $now->toDateString());
                                              })
                                              ->where(function ($query) use ($now) {
                                                  $query->whereNull('end_date')
                                                      ->orWhereDate('end_date', '>=', $now->toDateString());
                                              })
                                              ->get();

        foreach ($medications as $patientMedication) {
            $this->checkMedication($patientMedication, $from, $to);
        }
    }

    private function checkMedication(PatientMedication $patientMedication, Carbon $from, Carbon $to): void {
        $times = $patientMedication->reminder_times ?? [];

        if (!is_array($times)) {
            return;
        }

        foreach ($times as $time) {
            $scheduledAt = Carbon::parse($from->toDateString() . ' ' . $time);
            if ($scheduledAt->lt($from) || $scheduledAt->gt($to)) {
                continue;
            }
            $this->sendUpcomingAlert($patientMedication, $scheduledAt);
        }
    }

    private function sendUpcomingAlert(PatientMedication $patientMedication, Carbon $scheduledAt): void {
        $exists = MedicationAlert::query()
            ->where('patient_medication_id', $patientMedication->id)
            ->where('scheduled_at', $scheduledAt)
            ->where('type', 'upcoming')
            ->exists();

        if ($exists) {
            return;
        }

        MedicationAlert::create([
            'patient_medication_id' => $patientMedication->id,
            'scheduled_at' => $scheduledAt,
            'type' => 'upcoming',
        ]);

        SendUserNotification::dispatch($patientMedication->patient->user_id, 'MedicationDoseUpcoming', ['medication' => $patientMedication->medication->name, 'dosage' => $patientMedication->dosage ?? '', 'scheduled_at' => $scheduledAt->format('H:i'),]
        );
    }
}
