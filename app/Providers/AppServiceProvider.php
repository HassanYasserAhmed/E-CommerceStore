<?php

namespace App\Providers;

use AdminModelRepository;
use AdminRepository;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Payment\PaymentModelRepository;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Product\ProductModeleRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\CurrencyConverter;
use App\Services\PaymentService;
use App\Services\StripePaymentService;
use CategoryModelRepository;
use CategoryRepository;
use CategoryService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use TagModelRepository;
use TagRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('currency.converter', function () {
            return new CurrencyConverter(config('services.currency_converter.api_key'));
        });
        $this->app->bind(CartRepository::class, CartModelRepository::class);
        $this->app->bind(ProductRepository::class, ProductModeleRepository::class);
        $this->app->singleton(\Stripe\StripeClient::class, function () {
            return new \Stripe\StripeClient(config('services.stripe.secret'));
        });
        $this->app->bind(PaymentRepository::class, PaymentModelRepository::class);
        $this->app->bind(CategoryRepository::class, CategoryModelRepository::class);
        $this->app->bind(TagRepository::class, TagModelRepository::class);
        $this->app->bind(AdminRepository::class, AdminModelRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        validator::extend('filter', function ($attribute, $value, $parameters, $validator) {
            return $value != 'laravel';
        }, 'The value of :attribute cannot be :value app service provider');

        Paginator::useBootstrap();
    }
}
