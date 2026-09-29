<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\PatientSymptom;
use Illuminate\Support\Collection;

class SymptomAlertService
{
    /**
     * Handle a newly recorded symptom.
     */
    public function handle(PatientSymptom $patientSymptom): array
    {
        $patientSymptom->loadMissing('symptom.tips');

        $symptom = $patientSymptom->symptom;

        $isCritical = (bool) $symptom?->is_critical;

        $severity = (int) $patientSymptom->severity;

        /*
        |--------------------------------------------------------------------------
        | Determine alert level
        |--------------------------------------------------------------------------
        */

        $level = $this->determineLevel(isCritical: $isCritical, severity: $severity);

        /*
        |--------------------------------------------------------------------------
        | Get patient advice
        |--------------------------------------------------------------------------
        */

        $advice = $this->getAdvice($symptom);

        /*
        |--------------------------------------------------------------------------
        | Build result
        |--------------------------------------------------------------------------
        */

        return [
            'level'               => $level,
            'is_alert'             => in_array($level, ['warning', 'critical']),
            'should_notify_doctor' => $level === 'critical',
            'should_notify_family' => $level === 'critical',
            'advice' => $advice,
        ];
    }

    /**
     * Determine symptom alert level.
     */
    private function determineLevel(bool $isCritical, int $severity): string {
        /*
        |--------------------------------------------------------------------------
        | Critical symptom
        |--------------------------------------------------------------------------
        */

        if ($isCritical && $severity >= 4) {
            return 'critical';
        }

        /*
        |--------------------------------------------------------------------------
        | Moderate warning
        |--------------------------------------------------------------------------
        */

        if ($severity >= 3) {
            return 'warning';
        }

        /*
        |--------------------------------------------------------------------------
        | Normal symptom
        |--------------------------------------------------------------------------
        */

        return 'normal';
    }

    /**
     * Get advice configured for the symptom.
     */
    private function getAdvice($symptom): ?string
    {
        if (!$symptom) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Get enabled tip
        |--------------------------------------------------------------------------
        */

        $tip = $symptom->tips->where('status', 'enabled')->first();

        return $tip?->content;
    }

    /**
     * Get current alerts for patient dashboard.
     */
    public function getForDashboard(Patient $patient): Collection
    {
        $symptoms = PatientSymptom::query()
            ->where('patient_id', $patient->id)
            ->whereHas('symptom', function ($query) {
                $query->where('is_critical', true);
            })
            ->where('severity', '>=', 4)
            ->with('symptom')
            ->latest('recorded_at')
            ->get();

        return $symptoms->map(function ($patientSymptom) {

            $symptomName = $patientSymptom->symptom?->name ?? 'عرض صحي';

            return [
                'id' => $patientSymptom->id,
                'type' => 'critical_symptom',
                'severity' => 'critical',
                'title' => 'تنبيه صحي',
                'message' => "تم تسجيل عرض يحتاج إلى المتابعة: {$symptomName}.",
                'priority' => 110,
                'created_at' => $patientSymptom->recorded_at,
            ];
        });
    }
}
