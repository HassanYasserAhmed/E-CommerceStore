<?php
namespace App\Services;

use App\Models\Payment;
use App\Repositories\Payment\PaymentModelRepository;
use PaymentRepository;

class PaymentService {
    protected $paymentRepository;
    public function __construct() {
        $this->paymentRepository = new PaymentModelRepository();
    }
    public function create($order_id,$paymentIntent) {
        return $this->paymentRepository->create($order_id, $paymentIntent);
   } 
   public function confirm($order_id,$paymentIntent) {
        return $this->paymentRepository->confirm($order_id, $paymentIntent);
   }
}