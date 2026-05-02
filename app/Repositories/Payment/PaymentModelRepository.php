<?php
namespace App\Repositories\Payment;
use App\Models\Payment;
use Illuminate\Support\Facades\Request;

class PaymentModelRepository implements PaymentRepository {
    public function create($order_id,$paymentIntent) {
   $payment = new Payment();
        $payment->fill([
                'order_id' => $order_id,
                'amount' => $paymentIntent->amount / 100,
                'currency' => $paymentIntent->currency,
                'status' => 'pending',
                'method' => 'stripe',
                'transaction_id' => $paymentIntent->id,
                'transaction_data' =>json_encode($paymentIntent),
            ])->save();
    }
    public function confirm($order_id,$paymentIntent) {
        $payment = Payment::where('order_id', $order_id)->first();
        $payment->fill([
            'status' => 'completed',
            'transaction_data' =>json_encode($paymentIntent),
        ])->save();
    }
    public function find($id) {
        return Payment::where('order_id', $id)->first();
    }
}