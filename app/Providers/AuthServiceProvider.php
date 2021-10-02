<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (App::environment()) {
            VerifyEmail::toMailUsing(function ($notifiable, $url) {

                $parts = parse_url($url);

                $spaUrl = "https://www.xparts.ng/verify?id=".
                    $notifiable->getKey() ."&hash=" .
                    sha1($notifiable->getEmailForVerification())."&".
                    $parts['query'];
    
                return (new MailMessage)
                    ->subject('Verify Email Address')
                    ->line('Click the button below to verify your email address.')
                    ->action('Verify Email Address', $spaUrl);
    
            });
        }
    }
}
