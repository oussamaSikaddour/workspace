<?php

namespace App\Listeners\V1;

use App\Events\V1\NewUserPasswordEvent;
use App\Notifications\V1\NewUserPasswordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewUserPasswordListener
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
    public function handle(NewUserPasswordEvent $event): void
    {
        $user = $event->user;
        $password = $event->password;
        $user->notify(new NewUserPasswordNotification($password));
    }
}
