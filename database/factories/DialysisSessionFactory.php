<?php

namespace Database\Factories;

use App\Models\DialysisCenter;
use App\Models\DialysisSession;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DialysisSession>
 */
class DialysisSessionFactory extends Factory
{
    protected $model = DialysisSession::class;

    public function definition(): array
    {
        return [
            'patient_id' => Patient::query()->inRandomOrder()->value('id'),
            'center_id' => DialysisCenter::query()->inRandomOrder()->value('id'),
            'doctor_id' => Doctor::query()->inRandomOrder()->value('id'),

            'scheduled_at' => fake()
                ->dateTimeBetween('-30 days', '+30 days'),

            'started_at' => null,
            'ended_at' => null,

            'status' => 'scheduled',

            'session_type' => 'hemodialysis',

            'notes' => fake()->optional()->sentence(),

            'doctor_instructions' => fake()->optional()->sentence(),
        ];
    }

    public function completed(): static
    {
        return $this->state(function (array $attributes) {

            $scheduledAt = \Carbon\Carbon::parse($attributes['scheduled_at']);

            return [
                'scheduled_at' => $scheduledAt,
                'started_at' => $scheduledAt->copy()->addMinutes(
                    fake()->numberBetween(0, 15)
                ),
                'ended_at' => $scheduledAt->copy()->addHours(
                    fake()->randomFloat(1, 3.5, 5)
                ),
                'status' => 'completed',
                'notes' => fake()->optional()->sentence(),
                'doctor_instructions' => fake()->optional()->sentence(),
            ];
        });
    }

    public function missed(): static
    {
        return $this->state([
            'status' => 'missed',
            'started_at' => null,
            'ended_at' => null,
        ]);
    }

    public function confirmed(): static
    {
        return $this->state([
            'status' => 'confirmed',
            'started_at' => null,
            'ended_at' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state([
            'status' => 'scheduled',
            'started_at' => null,
            'ended_at' => null,
        ]);
    }

    public function cancelled(): static
    {
        return $this->state([
            'status' => 'cancelled',
            'started_at' => null,
            'ended_at' => null,
        ]);
    }
}
