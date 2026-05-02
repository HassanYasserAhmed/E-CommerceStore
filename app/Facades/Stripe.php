<?php
namespace App\Facades;

use App\Services\StripePaymentService;
use Illuminate\Support\Facades\Facade;

class Stripe extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return StripePaymentService::class;
    }
}