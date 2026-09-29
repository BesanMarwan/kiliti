<?php

namespace App\Services;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardAlertService
{
    public function getForPatient(Patient $patient): Collection
    {
        $alerts = collect();

        $alerts = $alerts->merge($this->fluidAlerts($patient));

        $alerts = $alerts->merge($this->medicationAlerts($patient));

        $alerts = $alerts->merge($this->dialysisAlerts($patient));

        $alerts = $alerts->merge($this->symptomAlerts($patient));

        return $alerts->sortByDesc('priority')->take(5)->values();
    }

    /**
     * Fluid Alerts
     */
    private function fluidAlerts(Patient $patient): Collection
    {
        $now = Carbon::now('Asia/Gaza');
        $today = $now->toDateString();

        $limit = (float) $patient->daily_fluid_limit;

        if ($limit <= 0) {
            return collect();
        }

        $consumed = (float) $patient->fluidLogs()
            ->whereDate('recorded_at', $today)
            ->sum('amount_ml');

        if ($consumed <= $limit) {
            return collect();
        }

        $percentage = round(($consumed / $limit) * 100);

        return collect([
            $this->makeAlert(
                type: 'fluid_limit_exceeded',
                severity: 'warning',
                title: 'تنبيه السوائل',
                message: "لقد تجاوزت الحد اليومي المسموح من السوائل ({$percentage}%).",
                priority: 100,
                createdAt: $now,
            ),
        ]);
    }

    /**
     * Medication Alerts
     */
    private function medicationAlerts(Patient $patient): Collection
    {
        $now = Carbon::now('Asia/Gaza');

//        $missed = $patient->medicationLogs()
//            ->where('status', 'missed')
//            ->whereDate('scheduled_at', $now->toDateString())
//            ->with('patientMedication.medication')
//            ->latest('scheduled_at')
//            ->get();

        $missed = \App\Models\MedicationLog::query()
            ->whereHas('patientMedication', function ($query) use ($patient) {
                $query->where('patient_id', $patient->id);
            })
            ->where('status', 'missed')
            ->whereDate('scheduled_at', $now->toDateString())
            ->with('patientMedication.medication')
            ->latest('scheduled_at')
            ->get();

        if ($missed->isEmpty()) {
            return collect();
        }

        $medication = $missed->first()->patientMedication?->medication;

        $medicationName = $medication?->name ?? 'أحد الأدوية';

        return collect([
            $this->makeAlert(
                type: 'missed_medication',
                severity: 'warning',
                title: 'جرعة دواء فائتة',
                message: "لديك جرعة فائتة من {$medicationName}.",
                priority: 90,
                createdAt: $missed->first()->scheduled_at,
            ),
        ]);
    }

    /**
     * Dialysis Alerts
     */
    private function dialysisAlerts(Patient $patient): Collection
    {
        $now = Carbon::now('Asia/Gaza');

        $nextSession = $patient->dialysisSessions()
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->where('scheduled_at', '>', $now)
            ->orderBy('scheduled_at')
            ->first();

        if (!$nextSession) {
            return collect();
        }

        $scheduledAt = Carbon::parse($nextSession->scheduled_at, 'Asia/Gaza');

        $hoursUntil = $now->diffInHours($scheduledAt, false);

        if ($hoursUntil > 24) {
            return collect();
        }

        return collect([
            $this->makeAlert(
                type: 'upcoming_dialysis',
                severity: 'info',
                title: 'جلسة غسيل قادمة',
                message: 'لديك جلسة غسيل كلى قادمة خلال 24 ساعة.',
                priority: 80,
                createdAt: $scheduledAt,
            ),
        ]);
    }

    /**
     * Critical Symptoms Alerts
     */
    private function symptomAlerts(Patient $patient): Collection
    {
        $now = Carbon::now('Asia/Gaza');

        $symptoms = $patient->patientSymptoms()
            ->whereDate('recorded_at', $now->toDateString())
            ->where('severity', '>=', 4)
            ->with('symptom')
            ->latest('recorded_at')
            ->get();

        if ($symptoms->isEmpty()) {
            return collect();
        }

        $symptom = $symptoms->first();

        $symptomName = $symptom->symptom?->name ?? 'عرض صحي';

        return collect([
            $this->makeAlert(
                type: 'critical_symptom',
                severity: 'critical',
                title: 'تنبيه صحي',
                message: "تم تسجيل {$symptomName} بدرجة شدة مرتفعة. يرجى الانتباه إلى حالتك الصحية.",
                priority: 110,
                createdAt: $symptom->recorded_at,
            ),
        ]);
    }

    /**
     * Build unified dashboard alert.
     */
    private function makeAlert(string $type, string $severity, string $title, string $message, int $priority, Carbon $createdAt,) {
        return [
            'id' => null,
            'type' => $type,
            'severity' => $severity,
            'title' => $title,
            'message' => $message,
            'is_read' => false,
            'priority' => $priority,
            'created_at' => $createdAt->toIso8601String(),
        ];
    }
}
