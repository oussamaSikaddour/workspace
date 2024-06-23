<?php

namespace App\Listeners\Auth;

use App\Mail\GeneratePasswordEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class GeneratePasswordListener
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
    public function handle(object $event): void
    {
        $user = $event->user;
        $password =$event->password;
        Mail::to($user->email)->send(new GeneratePasswordEmail($user,$password));
    }
}
