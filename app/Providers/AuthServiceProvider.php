<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        // Quan trọng: Laravel 12 cần gọi hàm này
        $this->registerPolicies();

        // Rule superadmin
        Gate::define('superadmin', function ($user) {
            return $user && $user->role === 'superadmin';
        });
    }
}
