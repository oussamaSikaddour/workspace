<?php

namespace App\Listeners\Auth;

use App\Events\Auth\EmailVerificationEvent;
use App\Mail\VerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

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
        Mail::to($user->email)->send(new VerificationMail($user));
        //
    }
}
