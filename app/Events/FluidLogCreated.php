<?php

namespace App\Events;

use App\Models\FluidLog;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FluidLogCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public FluidLog $fluidLog;

    /**
     * Create a new event instance.
     */
    public function __construct(FluidLog $fluidLog)
    {
        $this->fluidLog = $fluidLog;
    }


//    /**
//     * Get the channels the event should broadcast on.
//     *
//     * @return array<int, Channel>
//     */
//    public function broadcastOn(): array
//    {
//        return [
//            new PrivateChannel('channel-name'),
//        ];
//    }
}
