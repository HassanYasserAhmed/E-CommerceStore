<?php

namespace App\Providers;

use App\Services\CurrencyConverter;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('currency.converter',function(){
            return new CurrencyConverter(config('services.currency_converter.api_key'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        validator::extend('filter',function($attribute,$value,$parameters,$validator){
            return $value != 'laravel';
        },'The value of :attribute cannot be :value app service provider');

        Paginator::useBootstrap();
    }
}
