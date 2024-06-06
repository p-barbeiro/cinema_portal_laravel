<?php

namespace App\Providers;

use App\Models\Movie;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use App\Models\Course;
use App\Models\User;
use App\Policies\AdministrativePolicy;
use App\Policies\UserPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(User::class, AdministrativePolicy::class);

        Gate::define('use-cart', function (?User $user) {
            return $user === null || $user->type == 'A' || $user->type == 'E';
        });

        Gate::define('confirm-cart', function (User $user) {
            return $user->type == 'A' || $user->type == 'E';
        });

        try {

        } catch (\Exception $e) {
        }
    }
}
