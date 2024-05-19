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
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, AdministrativePolicy::class);

        Gate::define('use-cart', function (?User $user) {
            return $user === null || $user->type == 'A' || $user->type == 'S';
        });

        Gate::define('confirm-cart', function (User $user) {
            return $user->type == 'A' || $user->type == 'S';
        });

        // Gate::define('admin', function (User $user) {
        //     // Only "administrator" users can "admin"
        //     return $user->admin;
        // });

        try {
            // View::share adds data (variables) that are shared through all views (like global data)
            View::share('courses', Movie::take(10)->get());
        } catch (\Exception $e) {
            // If no Database exists, or Course table does not exist yet, an error will occour
            // This will ignore this error to avoid problems before migration is correctly executed
            // (When executing "composer update", when executing "php artisan migrate", etc)
        }
    }
}
