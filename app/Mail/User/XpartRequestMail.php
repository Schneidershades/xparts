<?php

namespace App\Mail\User;

use App\Models\User;
use App\Models\XpartRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class XpartRequestMail extends Mailable
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
        $baseUrl = env("WEB_APP_URL");
        $link = "{$baseUrl}/quote/{$this->xpartRequest->id}";
        
        return $this->markdown('emails.users.xpart.request')
            ->with('xp', $this->xpartRequest)
            ->with('user', $this->user)
            ->with('link', $link)
            ->subject(ucfirst($this->xpartRequest->status) . " xparts request created");
    }
}
