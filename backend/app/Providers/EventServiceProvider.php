<?php

namespace App\Providers;

use App\Events\V1\Auth\EmailVerificationEvent;
use App\Events\V1\Auth\LoginEvent;
use App\Events\V1\Auth\RestPasswordEvent;
use App\Events\V1\NewUserPasswordEvent;
use App\Listeners\V1\Auth\EmailVerificationListener;
use App\Listeners\V1\Auth\ResetPasswordListener;
use App\Listeners\V1\NewUserPasswordListener;
use App\Listeners\V1\SendNotificationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


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
        LoginEvent::class => [
            SendNotificationListener::class,
        ],
        EmailVerificationEvent::class => [
            EmailVerificationListener::class,
        ],
        RestPasswordEvent::class => [
            ResetPasswordListener::class,
        ],
        NewUserPasswordEvent::class => [
            NewUserPasswordListener::class
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
