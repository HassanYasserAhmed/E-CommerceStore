<?php

namespace App\Http\Controllers\Front;

use App\Facades\Stripe;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
class PaymentsController extends Controller
{
    public function create(Order $order)
    {
        return view('front.payments.create', [
            'order' => $order,
        ]);
    }
    public function createStripePaymentIntent(Order $order)
    {
         return Stripe::createIntent($order);
    }
    public function confirm(Request $request, Order $order)
    {
        return Stripe::confirmPayment($order,$request->query('payment_intent'));
    }
}
