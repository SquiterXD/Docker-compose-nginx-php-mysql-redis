<?php

namespace App\Events;

use App\Models\OM\Api\OrderLines;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderLinesDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $orderLine;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(OrderLines $orderLine)
    {
        $this->orderLine = $orderLine;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
