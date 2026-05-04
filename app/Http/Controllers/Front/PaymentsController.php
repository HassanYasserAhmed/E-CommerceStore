<?php

namespace App\Http\Controllers\Front;

use App\Facades\Stripe;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function __construct() {}
    public function create(Order $order)
    {
        return view('front.payments.create', [
            'order' => $order,
        ]);
    }
    public function createStripePaymentIntent(Order $order)
    {
        $paymentIntent = Stripe::createIntent($order);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }
    public function confirm(Request $request, Order $order)
    {
        $paymentIntent = Stripe::confirmPayment($order, $request->query('payment_intent'));

        if ($paymentIntent->status == "succeeded") {
            return redirect()->route('home')
                ->with('success', 'Payment Done Successfully!');
        }

        return redirect()->route('checkout', [
            'order' => $order,
            'status' => $paymentIntent->status,
        ]);
    }
}
