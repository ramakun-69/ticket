<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
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
        Gate::define('admin', function (User $user) {
            return $user->role == 'admin';
        });
        Gate::define('staff', function (User $user) {
            return $user->role == 'staff';
        });
        Gate::define('teknisi', function (User $user) {
            return $user->role == 'teknisi';
        });
        Gate::define('atasan', function (User $user) {
            return $user->role == 'atasan';
        });
        Gate::define('atasan teknisi', function (User $user) {
            return $user->role == 'atasan teknisi';
        });

        // Policies
        Gate::define('myTicket', [UserPolicy::class, 'myTicket']);
        Gate::define('produksiType', [UserPolicy::class, 'produksiType']);
        Gate::define('itType', [UserPolicy::class, 'itType']);
    }
}
