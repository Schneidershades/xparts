<?php

namespace App\Events;

use App\Models\XpartRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Http\Resources\Xpart\XpartRequestResource;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class XpartsUserRequestEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $xpartRequest;

    public function __construct(XpartRequest $xartRequest)
    {
        $this->xpartRequest = (new XpartRequestResource($xartRequest))->jsonSerialize();
    }

    public function broadcastOn()
    {
        return new Channel('new.xpart.request.from.user');
    }
}
