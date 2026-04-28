<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\product;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        product::class => ProductPolicy::class,
    ];

    public function register()
    {
        Gate::before(function ($user, $ability) {
            if ($user->super_admin) {
                return true;
            }
        });

        parent::register();
        $this->app->bind('abilities', function () {
            return include base_path('data/abilities.php');
        });

    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();
        // foreach($this->app->make('abilities') as $code => $label) {
        //     Gate::define($code,function($user) use ($code){
        //         return $user->hasAbility($code);
        //     });
        // }
    }
}
