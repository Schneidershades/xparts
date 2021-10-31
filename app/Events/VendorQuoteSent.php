<?php

namespace App\Events;

use App\Models\User;
use App\Models\Quote;
use App\Models\XpartRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Http\Resources\Quote\QuoteResource;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Http\Resources\Xpart\XpartRequestResource;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

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
        $this->vendor = [
            'id' => 1,
            'name' => "Adedeji Rotibi", 
        ];
        $this->xpartRequest = $xpartRequest;
        $this->quote = $quote;
    }
    
    public function broadcastWith()
    {
        return (new QuoteResource($this->quote))->jsonSerialize();
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
