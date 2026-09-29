<?php

namespace App\Jobs;

use App\Models\MedicationLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessMissedMedicationLogsJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $now = now();
        $missedBefore = $now->copy()->subMinutes(30);

        MedicationLog::query()
            ->where('status', 'pending')
            ->where('scheduled_at', '<=', $missedBefore)
            ->where(function ($query) use ($now) {
                $query->whereNull('snoozed_until')
                    ->orWhere('snoozed_until', '<=', $now);
            })
            ->chunkById(100, function ($logs) {

                foreach ($logs as $log) {
                    $log->update([
                        'status' => 'missed',
                    ]);
                }
            });
    }
}
