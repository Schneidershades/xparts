<?php

namespace App\Events;

use App\Models\Quote;
use App\Models\User;
use App\Models\XpartRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VendorQuoteSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vendor;

    public $xpartRequest;

    public $quote;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $vendor, XpartRequest $xpartRequest, Quote $quote)
    {
        $this->vendor = $vendor;
        $this->xpartRequest = $xpartRequest;
        $this->quote = $quote;
    }

    public function broadcastAs()
    {
        return 'VendorQuoteSent';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('vendor-quote-sent.' . $this->xpartRequest->id);
    }
}
