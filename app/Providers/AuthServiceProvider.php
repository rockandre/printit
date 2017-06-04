<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Request as Requests;
use App\User;
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
        Gate::define('edit-remove-request', function($user, Requests $request){
            return ($user->id == $request->owner_id) && $request->status != 2;
        });

        Gate::define('refuse-finish-request', function($user, Requests $request){
            return $user->isAdmin()  && $request->status == 0;
        });

        Gate::define('evaluate-request', function($user, Requests $request){
            return ($user->id == $request->owner_id) && $request->status == 2;
        });

        Gate::define('block-user', function($loggedUser, User $user){
            return $loggedUser->isAdmin() && $user->blocked == 0;
        });
    }
}
