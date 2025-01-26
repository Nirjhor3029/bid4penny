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

class PriceUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $itemId;
    public $newPrice;
    public $userName;
    public $totalBids;

    /**
     * Create a new event instance.
     */
    public function __construct($itemId, $newPrice,$userName,$totalBids)
    {
        $this->itemId = $itemId;
        $this->newPrice = $newPrice;
        $this->userName = $userName;
        $this->totalBids = $totalBids;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        Log::info('PriceUpdated event fired', [
            'item_id' => $this->itemId,
            'new_price' => $this->newPrice,
        ]);
        return [
            // new PrivateChannel('bids'),
            new Channel('bids'), // Or use PrivateChannel if necessary
        ];
    }

    // Optional: Specify a broadcast name
    public function broadcastAs()
    {
        return 'price.updated';
    }


}
