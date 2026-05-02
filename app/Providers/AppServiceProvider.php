<?php
namespace App\Providers;

use App\Repositories\Payment\PaymentModelRepository;
use App\Repositories\Payment\PaymentRepository as PaymentPaymentRepository;
use App\Services\CurrencyConverter;
use App\Services\PaymentService;
use App\Services\StripePaymentService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
         $this->app->bind(PaymentService::class, function ($app) {
            return new PaymentService($app->make(PaymentPaymentRepository::class));
        });
         $this->app->singleton(\Stripe\StripeClient::class, function () {
             return new \Stripe\StripeClient(config('services.stripe.secret'));
        });
        
        $this->app->bind(StripePaymentService::class, function ($app) {
            return new StripePaymentService($app->make(PaymentService::class), $app->make(\Stripe\StripeClient::class));
        });
        $this->app->bind(PaymentPaymentRepository::class, function ($app) {
            return new PaymentModelRepository();
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
