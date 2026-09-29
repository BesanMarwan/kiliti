<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\DialysisSession;
use Carbon\Carbon;

class DialysisAdherenceService
{
    public function calculate(Patient $patient, Carbon $from, Carbon $to): array {
        $sessions = DialysisSession::query()
                            ->where('patient_id', $patient->id)
                            ->whereBetween('scheduled_at', [
                                $from->copy()->startOfDay(),
                                $to->copy()->endOfDay(),
                            ])
                         ->whereIn('status', ['completed', 'missed', 'scheduled', 'confirmed'])
                        ->get();

        $completed  = $sessions->where('status', 'completed')->count();
        $missed     = $sessions->where('status', 'missed')->count();
        $pending    = $sessions->whereIn('status', ['scheduled', 'confirmed'])->count();
        $total      = $completed + $missed;

        $percentage = $total > 0 ? round(($completed / $total) * 100, 2) : null;

        return [
            'total' => $total,
            'completed' => $completed,
            'missed' => $missed,
            'pending' => $pending,
            'percentage' => 10,
        ];
    }
}
