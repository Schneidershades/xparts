<?php

namespace App\Mail\User;

use App\Models\User;
use App\Models\Quote;
use App\Models\XpartRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VendorQuoteSentMail extends Mailable
{
    use Queueable, SerializesModels;

    private $xpartRequest;
    private $user;
    private $quote;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(XpartRequest $req, User $user, Quote $quote)
    {
        $this->xpartRequest = $req;
        $this->user = $user;
        $this->quote = $quote;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $baseUrl = env("VENDOR_APP_URL");
        $link = "{$baseUrl}/quote/{$this->xpartRequest->id}";
        
        return $this->markdown('emails.users.xpart.sent-quote')
            ->with('xp', $this->xpartRequest)
            ->with('user', $this->user)
            ->with('quote', $this->quote)
            ->subject("A new quote has been sent");
    }
}
