<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant Superadmin & Union Admin all permissions, and Farmers self-profile/loan permissions
        Gate::before(function ($user, $ability) {
            if (is_superadmin() || (isset($user->role_id) && $user->role_id == 6)) {
                return true;
            }
            if (isset($user->role_id) && in_array($user->role_id, [13, 5])) {
                if (in_array($ability, [
                    'farmer-info-read',
                    'farmer-general-list-read',
                    'farmer-general-list-update',
                    'loan-info-read',
                    'loan-all-loan-apply-read',
                    'loan-all-loan-apply-create'
                ])) {
                    return true;
                }
            }
        });
    }
}
