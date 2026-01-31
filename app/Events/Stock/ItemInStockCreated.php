<?php

namespace App\Events\Stock;

use App\Models\ItemInStock;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemInStockCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ItemInStock $itemInStock;

    /**
     * Create a new event instance.
     */
    public function __construct(ItemInStock $itemInStock)
    {
        $this->itemInStock = $itemInStock;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
