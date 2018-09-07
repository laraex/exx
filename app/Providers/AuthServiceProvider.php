<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Laravel\Passport\Passport;

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
    public function boot(GateContract $gate)
    {
       // $this->registerPolicies();

        //

         $this->registerPolicies($gate);

         Passport::routes();

        $gate->define('view-messages', function ($user, $conversations) {
            return ($user->id === $conversations->user_one)||($user->id === $conversations->user_two);
        });
    }
}
