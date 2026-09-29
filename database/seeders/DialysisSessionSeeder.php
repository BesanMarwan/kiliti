<?php

namespace Database\Seeders;

use App\Models\DialysisCenter;
use App\Models\DialysisSession;
use App\Models\DialysisSessionRecord;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DialysisSessionSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::query()->get();
        $centers  = DialysisCenter::query()->get();
        $doctors  = Doctor::query()->get();

        if ($patients->isEmpty()) {
            $this->command->error('No patients found.');
            return;
        }

        if ($centers->isEmpty()) {
            $this->command->error('No dialysis centers found.');
            return;
        }

        if ($doctors->isEmpty()) {
            $this->command->warn('No doctors found. Sessions will be created without doctor_id.');
        }

        $totalSessions = 40;

        /*
        |--------------------------------------------------------------------------
        | Status distribution
        |--------------------------------------------------------------------------
        */

        $statuses = [
            'completed',
            'completed',
            'completed',
            'completed',
            'completed',

            'missed',
            'missed',

            'confirmed',
            'confirmed',
            'confirmed',

            'scheduled',
            'scheduled',
            'scheduled',

            'cancelled',
        ];

        for ($i = 0; $i < $totalSessions; $i++) {

            $patient = $patients->random();
            $center  = $centers->random();
            $doctor  = $doctors->isNotEmpty() ? $doctors->random() : null;

            /*
            |--------------------------------------------------------------------------
            | Choose status
            |--------------------------------------------------------------------------
            */

            $status = fake()->randomElement($statuses);

            /*
            |--------------------------------------------------------------------------
            | Date according to status
            |--------------------------------------------------------------------------
            */

            if (in_array($status, ['completed', 'missed'])) {

                $scheduledAt = Carbon::now('Asia/Gaza')
                                     ->subDays(fake()->numberBetween(1, 30))
                                     ->setTime(fake()->randomElement([8, 9, 10, 11, 14]), 0);

            } else {

                $scheduledAt = Carbon::now('Asia/Gaza')
                                         ->addDays(fake()->numberBetween(1, 30))
                                         ->setTime(fake()->randomElement([8, 9, 10, 11, 14]), 0);
            }

            /*
            |--------------------------------------------------------------------------
            | Create session
            |--------------------------------------------------------------------------
            */

            $session = DialysisSession::create([
                'patient_id'          => $patient->id,
                'center_id'           => $center->id,
                'doctor_id'           => $doctor?->id,
                'scheduled_at'        => $scheduledAt,
                'started_at'          => null,
                'ended_at'            => null,
                'status'              => $status,
                'session_type'        => 'hemodialysis',
                'notes'               => fake()->optional()->sentence(),
                'doctor_instructions' => fake()->optional()->sentence(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Completed session
            |--------------------------------------------------------------------------
            */

            if ($status === 'completed') {

                $startedAt = $scheduledAt->copy()->addMinutes(fake()->numberBetween(0, 15));
                $endedAt   = $startedAt->copy()->addMinutes(fake()->numberBetween(180, 300));

                $session->update([
                    'started_at' => $startedAt,
                    'ended_at' => $endedAt,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Create clinical record
                |--------------------------------------------------------------------------
                */

                $preWeight    = fake()->randomFloat(2, 55, 100);
                $fluidRemoved = fake()->randomFloat(2, 800, 3500);
                $postWeight   = max(40, $preWeight - ($fluidRemoved / 1000));

                DialysisSessionRecord::create([
                    'session_id'                      => $session->id,
                    'pre_weight'                      => $preWeight,
                    'post_weight'                     => round($postWeight, 2),
                    'blood_pressure_before_systolic'  => fake()->numberBetween(120, 170),
                    'blood_pressure_before_diastolic' => fake()->numberBetween(70, 105),
                    'blood_pressure_after_systolic'   => fake()->numberBetween(100, 150),
                    'blood_pressure_after_diastolic'  => fake()->numberBetween(60, 95),
                    'heart_rate'                      => fake()->numberBetween(60, 100),
                    'fluid_removed_ml'                => $fluidRemoved,
                    'session_notes'                   => fake()->randomElement(['Session completed without complications.', 'Patient tolerated the session well.', 'Routine dialysis session completed.', 'No complications reported.',]),
                ]);
            }
        }

        $this->command->info("{$totalSessions} dialysis sessions seeded successfully.");
    }
}
