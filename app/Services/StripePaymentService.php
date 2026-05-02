<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Request;
use PaymentRepository;
use Stripe\StripeClient;
class StripePaymentService
{
    protected StripeClient $stripe;
    protected PaymentService $paymentService;
    public  function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $this->paymentService = new PaymentService();
    }
    public function handle($request)
    {
        $payload = $request->getContent();
        \Log::debug('webhook event received', json_decode($payload, true));
    }

    public function createIntent(Order $order) {
    $amount = $this->calculateAmount($order);

         $paymentIntent = $this->stripe->paymentIntents->create([
            'amount' => $amount,
            'currency' => 'usd',
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        $this->paymentService->create($order->id, $paymentIntent);
          
        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }
    public function confirmPayment($order,$intentId) {
        $paymentIntent = $this->stripe->paymentIntents->retrieve(
            Request::query('payment_intent'),[]);

        if ($paymentIntent->status == "succeeded") {
            $this->paymentService->confirm($order->id, $paymentIntent);
            // event('payment.succeeded', $payment);
            return redirect()->route('home')->with('success', 'Payment Done Successfully!');
        }
        return redirect()->route('order.payments.create',[
            'order' => $order,
            'status' => $paymentIntent->status,
        ]);
    }

    public function calculateAmount(Order $order) {
        return (int) round(
            $order->orderItems->sum(function ($item) {
                return $item->price * $item->quantity;
            }) * 100
        );

    }
}
