<?php

namespace App\Providers;

use App\Events\Auth\EmailVerificationEvent;
use App\Events\Auth\GeneratePasswordEvent;
use App\Events\Auth\ReplyEvent;
use App\Listeners\Auth\EmailVerificationListener;
use App\Listeners\Auth\GeneratePasswordListener;
use App\Listeners\Auth\ReplyListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EmailVerificationEvent::class =>[
            EmailVerificationListener::class,
        ],
        GeneratePasswordEvent::class=>[
            GeneratePasswordListener::class
        ],
        ReplyEvent::class=>[
            ReplyListener::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
