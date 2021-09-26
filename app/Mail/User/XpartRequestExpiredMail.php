<?php

namespace App\Mail\User;

use App\Models\User;
use App\Models\XpartRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class XpartRequestExpiredMail extends Mailable
{
    use Queueable, SerializesModels;

    private $xpartRequest;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(XpartRequest $req, User $user)
    {
        $this->xpartRequest = $req;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.xpart.request-expired')
            ->with('xp', $this->xpartRequest)
            ->with('user', $this->user)
            ->subject("xparts request expired");
    }
}
