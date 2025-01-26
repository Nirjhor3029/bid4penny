<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PriceUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $itemId;
    public $newPrice;

    /**
     * Create a new event instance.
     */
    public function __construct($itemId, $newPrice)
    {
        $this->itemId = $itemId;
        $this->newPrice = $newPrice;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    // public function broadcastOn(): array
    // {
    //     return [
    //         new PrivateChannel('channel-name'),
    //     ];
    // }

    public function broadcastOn()
    {
        Log::info('PriceUpdated event fired', [
            'item_id' => $this->itemId,
            'new_price' => $this->newPrice,
        ]);
        
        return new Channel('bids');
    }
}
