<?php

namespace App\Jobs;

use App\Jobs\SendUserNotification;
use App\Models\MedicationAlert;
use App\Models\MedicationLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendMedicationReminderJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $now = now();

        /*
        |--------------------------------------------------------------------------
        | Normal medication reminders
        |--------------------------------------------------------------------------
        */

        MedicationLog::query()
            ->with([
                'patientMedication.patient',
                'patientMedication.medication',
            ])
            ->where('status', 'pending')
            ->where('scheduled_at', '<=', $now)
            ->where('scheduled_at', '>', $now->copy()->subMinutes(5))
            ->get()
            ->each(function (MedicationLog $log) {
                $this->sendReminder(
                    $log,
                    'upcoming',
                    $log->scheduled_at
                );
            });


        /*
        |--------------------------------------------------------------------------
        | Snoozed medication reminders
        |--------------------------------------------------------------------------
        */

        MedicationLog::query()
            ->with([
                'patientMedication.patient',
                'patientMedication.medication',
            ])
            ->where('status', 'pending')
            ->whereNotNull('snoozed_until')
            ->where('snoozed_until', '<=', $now)
            ->where('snoozed_until', '>', $now->copy()->subMinutes(5))
            ->get()
            ->each(function (MedicationLog $log) {
                $this->sendReminder(
                    $log,
                    'upcoming',
                    $log->snoozed_until
                );
            });
    }


    private function sendReminder(MedicationLog $log, string $type, $scheduledAt): void {
        $patientMedication = $log->patientMedication;

        if (!$patientMedication) {
            return;
        }

        $patient = $patientMedication->patient;

        if (!$patient || !$patient->user_id) {
            return ;
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate notifications
        |--------------------------------------------------------------------------
        */

        $exists = MedicationAlert::query()
            ->where('patient_medication_id', $patientMedication->id)
            ->where('scheduled_at', $scheduledAt)
            ->where('type', $type)
            ->exists();

        if ($exists) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Create alert record
        |--------------------------------------------------------------------------
        */

        MedicationAlert::create([
            'patient_medication_id' => $patientMedication->id,
            'scheduled_at' => $scheduledAt,
            'type' => $type,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Send FCM notification
        |--------------------------------------------------------------------------
        */

        SendUserNotification::dispatch(
            $patient->user_id,
            'MedicationDoseUpcoming',
            [
                'medication' => $patientMedication->medication?->name ?? '',
                'dosage' => $patientMedication->dosage ?? '',
                'scheduled_at' => $scheduledAt->format('H:i'),
            ]
        );
    }
}
