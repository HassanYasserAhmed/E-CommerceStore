<?php

namespace App\Providers;

use App\Services\CurrencyConverter;
use App\Services\StripePaymentService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use PaymentRepository;

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
        $this->app->bind(StripePaymentService::class, function ($app) {
            return new StripePaymentService();
        });
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
