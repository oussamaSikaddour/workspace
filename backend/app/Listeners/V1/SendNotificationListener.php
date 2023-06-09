<?php

namespace App\Listeners\V1;

use App\Events\V1\Auth\LoginEvent;
use App\Notifications\V1\Auth\LoginNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotificationListener
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
    public function handle(LoginEvent $event): void
    {
        $user = $event->user;
        $user->notify(new LoginNotification($user));
    }
}
