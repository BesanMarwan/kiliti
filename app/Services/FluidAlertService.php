<?php

namespace App\Services;

use App\Jobs\SendUserNotification;
use App\Models\FluidAlert;
use App\Models\FluidLog;
use App\Models\Patient;

class FluidAlertService
{
    public function check(Patient $patient, string $date): ?string
    {
        $limit = (float) $patient->daily_fluid_limit;
        \Log::info($limit);

        if ($limit <= 0) {
            return null;
        }

        $totalConsumed = (float) $patient->fluidLogs()->whereDate('recorded_at', $date)->sum('amount_ml');

        $percentage = ($totalConsumed / $limit) * 100;

        $status =  match (true) {
            $percentage > 100 => 'exceeded',
            $percentage >= 90 => 'warning',
            $percentage >= 80 => 'approaching',
            default => null,
        };

        if (!$status) {
            return null;
        }
        /*
         * check if the fluid notification send before
         * and prevent send more than notification
         */
        $alreadySent = FluidAlert::query()->where('patient_id', $patient->id)->whereDate('date', $date)->where('type', $status)->exists();

        if ($alreadySent) {
            return null;
        }

        /*
         * store notification and reminder befor send
         */
        FluidAlert::create([
            'patient_id' => $patient->id,
            'date' => $date,
            'type' => $status,
            'consumed_ml' => $totalConsumed,
            'limit_ml' => $limit,
        ]);
        SendUserNotification::dispatch($patient->user_id, $this->getNotificationKey($status), ['consumed' => $totalConsumed, 'limit' => $limit, 'percentage' => round($percentage, 2)]);
    }



    private function getNotificationKey(string $status): string
    {
        return match ($status) {
            'approaching' => 'FluidLimitApproaching',
            'warning' => 'FluidLimitWarning',
            'exceeded' => 'FluidLimitExceeded',
        };
    }
}
