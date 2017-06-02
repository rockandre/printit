<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Request as Requests;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerUserPolicies();
        //
    }

    public function registerUserPolicies()
    {
        Gate::define('administrator', function($user){
            return $user->isAdmin();
        });
        Gate::define('requestOwner', function($user, Requests $request){
            return $user->id == $request->owner_id;
        });
    }
}
