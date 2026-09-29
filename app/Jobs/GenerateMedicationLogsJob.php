<?php

namespace App\Jobs;

use App\Models\PatientMedication;
use App\Services\MedicationScheduleService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateMedicationLogsJob implements ShouldQueue
{
    use Queueable;

    public function handle(MedicationScheduleService $scheduleService): void {

        PatientMedication::query()
            ->where('status', 'active')
            ->where('reminder_enabled', true)
            ->whereNotNull('reminder_times')
            ->chunkById(100, function ($medications) use ($scheduleService) {
                foreach ($medications as $medication) {
                    $scheduleService->generateForPeriod($medication, now()->startOfDay(), now()->addDays(2)->endOfDay());
                }
            });
    }
}
