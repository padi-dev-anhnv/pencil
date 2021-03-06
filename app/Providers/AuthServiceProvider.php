<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\UserPolicy;
use App\User;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('author-guide', function ($user) {
            $array_allow =  ['admin','instruction_manager'];
            $user_role = $user->role->type;
            return in_array($user_role, $array_allow);
        });
/*
        Gate::define('list-account', function ($user) {
            $array_allow = ['admin'];
            $user_role = $user->role->name;
            return in_array($user_role, $array_allow);
        });
        */
    }
}
