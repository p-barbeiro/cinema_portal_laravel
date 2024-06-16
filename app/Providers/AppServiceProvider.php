<?php

namespace App\Providers;

use App\Models\Configuration;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Policies\ConfigurationPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);

        Gate::define('viewStatistics', function (User $user) {
            return $user->type == 'A';
        });

        Gate::define('use-cart', function (?User $user) {
            return $user === null || $user->type == 'C';
        });

        Gate::define('confirm-cart', function (?User $user) {
            return $user === null || $user->type == 'C';
        });
    }
}
