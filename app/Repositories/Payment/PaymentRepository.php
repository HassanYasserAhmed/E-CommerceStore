<?php

namespace App\Repositories\Payment;
interface PaymentRepository {
    public function create($order_id,$paymentIntent);
    public function confirm($order_id,$paymentIntent);
    public function find($id);
}