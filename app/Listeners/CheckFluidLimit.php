<?php

namespace App\Listeners;

use App\Events\FluidLogCreated;
use App\Services\FluidAlertService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckFluidLimit
{
    /**
     * Create the event listener.
     */
    protected FluidAlertService $fluidAlertService;
    public function __construct( FluidAlertService $fluidAlertService)
    {
        $this->fluidAlertService = $fluidAlertService;
    }

    /**
     * Handle the event.
     */
    public function handle(FluidLogCreated $event): void
    {
        $fluidLog = $event->fluidLog;

        $this->fluidAlertService->check($fluidLog->patient, (String)$fluidLog->recorded_at->toDateString());


    }
}
