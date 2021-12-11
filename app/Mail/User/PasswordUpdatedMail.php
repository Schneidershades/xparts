<?php

namespace App\Mail\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $passwordDetails;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $passwordDetails)
    {
        $this->user = $user;
        $this->passwordDetails = $passwordDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {        
        return $this->markdown('emails.users.xpart.password-changed')
            ->with('user', $this->user)
            ->with('passwordDetails', $this->passwordDetails)
            ->subject("Your password was changed");
    }
}
