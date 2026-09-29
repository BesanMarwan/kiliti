<?php

namespace App\Observers;

use App\Events\FluidLogCreated;
use App\Events\PatientAdherenceChanged;
use App\Models\FluidLog;

class FluidLogObserver
{
    /**
     * Handle the FluidLog "created" event.
     */
    public function created(FluidLog $fluidLog): void
    {
//        FluidLogCreated::dispatch($fluidLog);
//        PatientAdherenceChanged::dispatch($fluidLog->patient_id);

    }

    /**
     * Handle the FluidLog "updated" event.
     */
    public function updated(FluidLog $fluidLog): void
    {
        PatientAdherenceChanged::dispatch($fluidLog->patient_id);
    }

    /**
     * Handle the FluidLog "deleted" event.
     */
    public function deleted(FluidLog $fluidLog): void
    {
        PatientAdherenceChanged::dispatch($fluidLog->patient_id);
    }

    /**
     * Handle the FluidLog "restored" event.
     */
    public function restored(FluidLog $fluidLog): void
    {
        //
    }

    /**
     * Handle the FluidLog "force deleted" event.
     */
    public function forceDeleted(FluidLog $fluidLog): void
    {
        //
    }
}
