<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Enums\UserableTypesEnum;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('super-admin-access', [UserPolicy::class, 'isSuperAdmin']);
        Gate::define('admin-access', [UserPolicy::class, 'isAdmin']);
        Gate::define('user-access', [UserPolicy::class, 'isUser']);
        Gate::define('only-owner-access', [UserPolicy::class, 'onlyOwner']);
        Gate::define('approver-access', [UserPolicy::class, 'isApprover']);
    }
}
