<?php

namespace App\Providers\RepositoryServiceProviders;

use App\Repositories\Product\ProductModeleRepository;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
       
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
