<?php

namespace App\Services;

use App\Models\Patient;
use Carbon\Carbon;

class SmartNoteService
{
    /**
     * Return the most relevant positive smart note for the patient.
     */
    public function getForPatient(Patient $patient): ?array
    {
        $notes = [];

        if ($note = $this->fluidInsight($patient)) {
            $notes[] = $note;
        }

        if ($note = $this->medicationInsight($patient)) {
            $notes[] = $note;
        }

        if ($note = $this->dialysisInsight($patient)) {
            $notes[] = $note;
        }

        if ($note = $this->measurementInsight($patient)) {
            $notes[] = $note;
        }

        if ($note = $this->overallAdherenceInsight($patient)) {
            $notes[] = $note;
        }

        if (empty($notes)) {
            return null;
        }

        return collect($notes)->sortByDesc('priority')->first();
    }

    /**
     * ---------------------------------------------------------
     * 1. Fluid Streak
     * ---------------------------------------------------------
     */
    private function fluidInsight(Patient $patient): ?array
    {
        $streak = $this->calculateFluidStreak($patient);

        if ($streak >= 7) {
            return [
                'type' => 'success',
                'key' => 'fluid_streak_7',
                'priority' => 100,
                'title' => 'ملاحظة ذكية',
                'message' => "رائع! حافظت على الحد المسموح به من السوائل لمدة {$streak} أيام متتالية. استمر بهذا الأداء الرائع 👏",
            ];
        }

        if ($streak >= 3) {
            return [
                'type' => 'success',
                'key' => 'fluid_streak_3',
                'priority' => 90,
                'title' => 'ملاحظة ذكية',
                'message' => "أحسنت! حافظت على الحد المسموح به من السوائل لمدة {$streak} أيام متتالية. استمر بهذا الأداء الرائع 👏",
            ];
        }

        return null;
    }

    private function calculateFluidStreak(Patient $patient): int
    {
        $limit = (float) $patient->daily_fluid_limit;

        if ($limit <= 0) {
            return 0;
        }

        $streak = 0;

        $date = Carbon::now('Asia/Gaza')->subDay();

        while (true) {

            $total = (float) $patient->fluidLogs()
                ->whereDate('recorded_at', $date->toDateString())
                ->sum('amount_ml');

            if ($total <= 0) {
                break;
            }

            //exceed daily fluid limit
            if ($total > $limit) {
                break;
            }

            $streak++;

            $date->subDay();
            if ($streak >= 30) {
                break;
            }
        }

        return $streak;
    }

    /**
     * ---------------------------------------------------------
     * 2. Medication Adherence
     * ---------------------------------------------------------
     */
    private function medicationInsight(Patient $patient): ?array
    {
        $records = $patient->adherenceRecords()
                           ->where('date', '>=', Carbon::now('Asia/Gaza')->subDays(6)->toDateString())
                           ->whereNotNull('medication_score')
                           ->orderByDesc('date')
                           ->get();

        if ($records->count() < 3) {
            return null;
        }

        $scores = $records->pluck('medication_score');

        $average = round($scores->avg(), 2);

        if ($average >= 90) {
            return [
                'type' => 'success',
                'key' => 'medication_adherence',
                'priority' => 85,
                'title' => 'ملاحظة ذكية',
                'message' => 'رائع! تحافظ على انتظامك في تناول أدويتك. استمر على هذا الالتزام 💊👏',
            ];
        }

        return null;
    }

    /**
     * ---------------------------------------------------------
     * 3. Dialysis Adherence
     * ---------------------------------------------------------
     */
    private function dialysisInsight(Patient $patient): ?array
    {
        $records = $patient->adherenceRecords()
                          ->where('date', '>=', Carbon::now('Asia/Gaza')->subDays(13)->toDateString())
                          ->whereNotNull('dialysis_score')
                          ->orderByDesc('date')
                          ->get();

        if ($records->count() < 2) {
            return null;
        }

        $average = round($records->pluck('dialysis_score')->avg(), 2);

        if ($average >= 90) {
            return [
                'type' => 'success',
                'key' => 'dialysis_adherence',
                'priority' => 80,
                'title' => 'ملاحظة ذكية',
                'message' => 'أحسنت! تحافظ على انتظامك في جلسات الغسيل. استمر في الالتزام بمواعيد جلساتك 🩺👏',
            ];
        }

        return null;
    }

    /**
     * ---------------------------------------------------------
     * 4. Health Measurements
     * ---------------------------------------------------------
     */
    private function measurementInsight(Patient $patient): ?array
    {
        $records = $patient->adherenceRecords()
                            ->where('date', '>=', Carbon::now('Asia/Gaza')->subDays(6)->toDateString())
                            ->whereNotNull('measurement_score')
                            ->orderByDesc('date')
                            ->get();

        if ($records->count() < 3) {
            return null;
        }

        $average = round(
            $records->pluck('measurement_score')->avg(),
            2
        );

        if ($average >= 90) {
            return [
                'type' => 'success',
                'key' => 'measurement_tracking',
                'priority' => 70,
                'title' => 'ملاحظة ذكية',
                'message' => 'ممتاز! تحافظ على متابعة قياساتك الصحية بشكل منتظم 📊👏',
            ];
        }

        return null;
    }

    /**
     * ---------------------------------------------------------
     * 5. Overall Adherence
     * ---------------------------------------------------------
     */
    private function overallAdherenceInsight(Patient $patient): ?array
    {
        $records = $patient->adherenceRecords()
                           ->where('date', '>=', Carbon::now('Asia/Gaza')->subDays(6)->toDateString())
                           ->whereNotNull('overall_score')
                           ->orderByDesc('date')
                           ->get();

        if ($records->count() < 3) {
            return null;
        }

        $average = round($records->pluck('overall_score')->avg(), 2);

        if ($average >= 90) {
            return [
                'type' => 'success',
                'key' => 'overall_adherence',
                'priority' => 60,
                'title' => 'ملاحظة ذكية',
                'message' => 'أداء رائع! تحافظ على مستوى ممتاز من الالتزام بخطة المتابعة الخاصة بك ⭐👏',
            ];
        }

        return null;
    }
}
