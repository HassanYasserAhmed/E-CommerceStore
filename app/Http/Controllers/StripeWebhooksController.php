<?php

namespace App\Http\Controllers;

use App\Facades\StripeService;
use Illuminate\Http\Request;
use Stripe\Stripe;

class StripeWebhooksController extends Controller
{
    public function handle(Request $request)
    {
       StripeService::handle($request);
    }
}
