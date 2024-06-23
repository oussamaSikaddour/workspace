<?php

namespace App\Listeners\Auth;

use App\Events\Auth\ReplyEvent;
use App\Mail\ReplyMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ReplyListener
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
    public function handle(ReplyEvent $event): void
    {
        $reply = $event->reply;
        Mail::to($reply["email"])->send(new ReplyMail($reply));
    }
}
