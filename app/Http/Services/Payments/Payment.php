<?php

namespace App\Http\Services\Payments;


interface PaymentInterface{
    public function payment($amount, $order_id);
}