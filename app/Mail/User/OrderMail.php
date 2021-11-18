<?php

namespace App\Mail\User;

use App\Models\User;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    private $order;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $req, User $user)
    {
        $this->order = $req;
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
        
        return $this->markdown('emails.users.xpart.sent-quote')
            ->with('order', $this->order)
            ->with('user', $this->user)
            ->with('link', $link)
            ->subject("Your order has processed");
    }
}
