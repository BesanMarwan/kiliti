<?php

namespace App\Listeners;

use App\Events\PatientAdherenceChanged;
use App\Jobs\CalculateDailyAdherence;

class QueueAdherenceCalculation
{
    public function handle(PatientAdherenceChanged $event): void
    {
        CalculateDailyAdherence::dispatch($event->patientId, $event->getDate());
    }
}
