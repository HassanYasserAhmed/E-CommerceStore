<?php

namespace App\Providers;

use AdminModelRepository;
use AdminRepository;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Category\CategoryModelRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Checkout\CheckoutModelRepository;
use App\Repositories\Checkout\CheckoutRepository;
use App\Repositories\Payment\PaymentModelRepository;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Product\ProductModelRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Tag\TagModelRepository as TagTagModelRepository;
use App\Repositories\Tag\TagRepository as TagTagRepository;
use App\Services\CurrencyConverter;
use App\Services\CurrencyConverterService as CurrencyConverterService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use RoleModelRepository;
use RoleRepository;

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
        $this->app->bind(ProductRepository::class, ProductModelRepository::class);
        $this->app->singleton(\Stripe\StripeClient::class, function () {
            return new \Stripe\StripeClient(config('services.stripe.secret'));
        });
        $this->app->bind(CurrencyConverterService::class,CurrencyConverterService::class);
        $this->app->bind(PaymentRepository::class, PaymentModelRepository::class);
        $this->app->bind(CategoryRepository::class,CategoryModelRepository::class);
        $this->app->bind(TagTagRepository::class, TagTagModelRepository::class);
        $this->app->bind(AdminRepository::class, AdminModelRepository::class);
        $this->app->bind(RoleRepository::class,RoleModelRepository::class);
        $this->app->bind(CheckoutRepository::class,CheckoutModelRepository::class);
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
