<?php

namespace Database\Factories;

use App\Models\DialysisSession;
use App\Models\DialysisSessionRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DialysisSessionRecord>
 */
class DialysisSessionRecordFactory extends Factory
{
    protected $model = DialysisSessionRecord::class;

    public function definition(): array
    {
        $preWeight    = fake()->randomFloat(2, 60, 100);

        $fluidRemoved = fake()->randomFloat(2, 800, 3500);

        $postWeight   = max(40, $preWeight - ($fluidRemoved / 1000));

        return [
            'session_id'                      => DialysisSession::factory(),
            'pre_weight'                      => $preWeight,
            'post_weight'                     => round($postWeight, 2),
            'blood_pressure_before_systolic'  => fake()->numberBetween(120, 170),
            'blood_pressure_before_diastolic' => fake()->numberBetween(70, 105),
            'blood_pressure_after_systolic'   => fake()->numberBetween(100, 150),
            'blood_pressure_after_diastolic'  => fake()->numberBetween(60, 95),
            'heart_rate'                      => fake()->numberBetween(60, 100),
            'fluid_removed_ml'                => $fluidRemoved,
            'session_notes'                   => fake()->optional()->sentence(),
        ];
    }
}
