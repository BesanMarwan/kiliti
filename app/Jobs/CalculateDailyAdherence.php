<?php

namespace App\Jobs;

use App\Services\AdherenceCalculator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateDailyAdherence implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public int $patientId, public string $date) {

    }

    public function handle(AdherenceCalculator $calculator): void
    {
        $calculator->calculate(patientId: $this->patientId, date: $this->date);
    }
}
