<?php

namespace App\Http\Controllers;

use App\Facades\Stripe;
use Illuminate\Http\Request;

class StripeWebhooksController extends Controller
{
    public function handle(Request $request)
    {
       Stripe::handle($request);
    }
}