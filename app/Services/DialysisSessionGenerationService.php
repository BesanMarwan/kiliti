<?php

namespace App\Services;

use App\Models\DialysisSession;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DialysisSessionGenerationService
{
    private const TIMEZONE = 'Asia/Gaza';

    public function generate(array $data): int
    {
        return DB::transaction(function () use ($data) {

            $startDate = Carbon::parse($data['start_date'], self::TIMEZONE)->startOfDay();

            $endDate = !empty($data['end_date'])
                ? Carbon::parse(
                    $data['end_date'],
                    self::TIMEZONE
                )->endOfDay()
                : $startDate->copy()
                    ->addMonths(3)
                    ->endOfDay();

            /*
             * 1. إنشاء قائمة الجلسات التي سيتم توليدها
             */
            $scheduledDates = $this->generateScheduledDates(
                $startDate,
                $endDate,
                $data['days'],
                $data['time']
            );

            /*
             * 2. التأكد من عدم وجود تعارض
             */
            $this->validateNoConflicts(
                patientId: (int) $data['patient_id'],
                scheduledDates: $scheduledDates
            );

            /*
             * 3. إنشاء الجلسات
             */
            $created = 0;

            foreach ($scheduledDates as $scheduledAt) {

                DialysisSession::create([
                    'patient_id' => $data['patient_id'],
                    'center_id' => $data['center_id'],
                    'doctor_id' => $data['doctor_id'] ?? null,
                    'scheduled_at' => $scheduledAt,
                    'status' => 'scheduled',
                    'session_type' => $data['session_type'],
                ]);

                $created++;
            }

            return $created;
        });
    }

    /**
     * Generate all concrete dialysis session dates.
     */
    private function generateScheduledDates(Carbon $startDate, Carbon $endDate, array $days, string $time): array {

        $scheduledDates = [];

        for (
            $date = $startDate->copy();
            $date->lte($endDate);
            $date->addDay()
        ) {

            $dayName = strtolower($date->format('l'));

            if (!in_array($dayName, $days, true)) {
                continue;
            }

            $scheduledAt = $date->copy()
                ->setTimeFromTimeString($time);

            $scheduledDates[] = $scheduledAt;
        }

        return $scheduledDates;
    }

    /**
     * Validate that the patient has no conflicting sessions.
     *
     * Cancelled sessions do NOT count as conflicts.
     */
    private function validateNoConflicts(
        int $patientId,
        array $scheduledDates
    ): void {
        $dates = collect($scheduledDates)
            ->map(fn ($date) => Carbon::parse($date, self::TIMEZONE)->toDateString())
            ->unique()
            ->values();

        $conflictingDates = DialysisSession::query()
            ->where('patient_id', $patientId)
            ->where('status', '!=', 'cancelled')
            ->whereIn(
                DB::raw('DATE(scheduled_at)'),
                $dates->all()
            )
            ->pluck('scheduled_at')
            ->map(fn ($date) => Carbon::parse($date)->format('Y-m-d'))
            ->unique()
            ->values();

        if ($conflictingDates->isNotEmpty()) {

            throw ValidationException::withMessages([
                'start_date' =>
                    'لا يمكن إنشاء الجدول لأن هناك جلسات موجودة مسبقًا في التواريخ التالية: '
                    . $conflictingDates->implode('، ')
            ]);
        }
    }


    public function generateForPatient(Patient $patient): int
    {
        if (!$patient->dialysis_start_date || !$patient->sessions_per_week || !$patient->dialysis_center_id || !$patient->dialysis_time || empty($patient->dialysis_days)) {
            return 0;
        }

        return $this->generate([
            'patient_id' => $patient->id,
            'center_id' => $patient->dialysis_center_id,
            'doctor_id' => $patient->doctor_id,
            'session_type' => $patient->dialysis_type,
            'start_date' => $patient->dialysis_start_date->format('Y-m-d'),
            'sessions_per_week' => $patient->sessions_per_week,
            'days' => $patient->dialysis_days,
            'time' => $patient->dialysis_time,
        ]);
    }
}
