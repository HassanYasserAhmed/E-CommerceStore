<?php

use phpDocumentor\Reflection\Types\Integer;

interface PaymentRepository {
    public function create($order_id,$paymentIntent);
    public function confirm($order_id,$paymentIntent);
    public function find($id);

}