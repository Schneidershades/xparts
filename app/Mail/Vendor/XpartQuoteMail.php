<?php

namespace App\Mail\Vendor;

use App\Models\User;
use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class XpartQuoteMail extends Mailable
{
    use Queueable, SerializesModels;

    private $quote;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Quote $quote, User $user)
    {
        $this->xpartRequest = $quote;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $baseUrl = env("VENDOR_APP_URL");
        $link = "{$baseUrl}/quote/{$this->quote->id}";
        
        return $this->markdown('emails.vendor.xpart.quote')
            ->with('xp', $this->quote)
            ->with('user', $this->user)
            ->with('link', $link)
            ->subject("Your Quote Request {$this->quote->status}");
    }
}
