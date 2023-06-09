<?php

namespace App\Listeners\V1\Auth;

use App\Events\V1\Auth\EmailVerificationEvent;
use App\Notifications\V1\Auth\EmailVerificationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailVerificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EmailVerificationEvent $event): void
    {
        $user = $event->user;
        $user->notify(new  EmailVerificationNotification());
        //
    }
}
