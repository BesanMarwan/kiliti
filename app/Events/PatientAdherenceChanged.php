<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PatientAdherenceChanged
{
    use Dispatchable, SerializesModels;

    public function __construct(public int $patientId, public ?string $date = null) {
    }

    public function getDate(): string
    {
        return $this->date ?? now()->toDateString();
    }
}
