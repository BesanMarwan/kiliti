<?php

namespace App\Services;

use App\Models\AdherenceRecord;
use App\Models\DialysisSession;
use App\Models\HealthMeasurement;
use App\Models\Patient;
use Illuminate\Support\Carbon;

class AdherenceCalculator
{
    public function __construct(){

     }
    public function calculate(int $patientId, string $date): AdherenceRecord
    {
        $patient = Patient::findOrFail($patientId);

        $dialysisScore = $this->calculateDialysisScore($patient, $date);

        $medicationScore = $this->calculateMedicationScore($patient, $date);

        $fluidScore = $this->calculateFluidScore($patient, $date);

        $measurementScore = $this->calculateMeasurementScore($patient, $date);

        $overallScore = $this->calculateOverallScore($dialysisScore, $medicationScore, $fluidScore, $measurementScore);

        return AdherenceRecord::updateOrCreate(
            [
                'patient_id' => $patientId,
                'date' => $date,
            ],
            [
                'dialysis_score' => $dialysisScore,
                'medication_score' => $medicationScore,
                'fluid_score' => $fluidScore,
                'measurement_score' => $measurementScore,
                'overall_score' => $overallScore,
            ]
        );
    }

    private function calculateDialysisScore(Patient $patient, string $date): float {
        // TODO: implement dialysis calculation
        $sessions = DialysisSession::query()
                             ->where('patient_id', $patient->id)
                             ->whereDate('scheduled_at', $date)
                             ->where('scheduled_at', '<=', now('Asia/Gaza'))
                             ->whereIn('status', ['completed', 'missed'])
                             ->get();

        $totalSessions = $sessions->count();

        if ($totalSessions === 0) {
            return 0;
        }

        $completedSessions = $sessions->where('status', 'completed')->count();

        return round(($completedSessions / $totalSessions) * 100, 2);
    }


    private function calculateMedicationScore(Patient $patient, string $date): float {

            $logs = $patient->medicationLogs()->whereDate('scheduled_at', $date)->get();
            $totalDoses = $logs->whereIn('status', ['taken', 'missed'])->count();

            if ($totalDoses === 0) {
                return 0;
            }
            $takenDoses = $logs->where('status', 'taken')->count();

            return round(($takenDoses / $totalDoses) * 100, 2);
    }

    private function calculateFluidScore(Patient $patient, string $date): float {

        $fluidLimit = (float) $patient->daily_fluid_limit;

        if ($fluidLimit <= 0) {
            return 0;
        }

        $totalConsumed = (float) $patient->fluidLogs()->whereDate('recorded_at', $date)->sum('amount_ml');

        if ($totalConsumed <= $fluidLimit) {
            return 100;
        }

        $excessPercentage = (($totalConsumed - $fluidLimit) / $fluidLimit) * 100;

        $score = 100 - $excessPercentage;

        return round(max(0, $score), 2);

    }

    private function calculateMeasurementScore(Patient $patient, string $date): float {
        // TODO: implement measurement calculation

        $measurements = HealthMeasurement::query()
                                  ->where('patient_id', $patient->id)
                                  ->whereDate('measured_at', $date)
                                  ->whereIn('type', ['weight', 'blood_pressure',])
                                  ->get();

        $hasWeight        = $measurements->where('type', 'weight')->isNotEmpty();
        $hasBloodPressure = $measurements->where('type', 'blood_pressure')->isNotEmpty();

        if ($hasWeight && $hasBloodPressure) {
            return 100;
        }

        if ($hasWeight || $hasBloodPressure) {
            return 50;
        }
        return 0;
    }

    private function calculateOverallScore(float $dialysisScore, float $medicationScore, float $fluidScore, float $measurementScore): float {
        return round(($dialysisScore * 0.30) + ($medicationScore * 0.30) + ($fluidScore * 0.20) + ($measurementScore * 0.20), 2);
    }
}
