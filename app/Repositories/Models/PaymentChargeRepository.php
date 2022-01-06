<?php

namespace App\Repositories\Models;

use App\Models\PaymentCharge;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ApplicationRepository;

class PaymentChargeRepository extends ApplicationRepository
{
    public function builder(): Builder
    {
        return PaymentCharge::query();
    }

    public function findPaymentCharges($payment_method, $payment_gateway) : array
    {
        return PaymentCharge::where('payment_method_id', $payment_method)->where('gateway', $payment_gateway)->first();
    }

    public function findChargeFinalAmountViaPercetageOrAmount($payment_method, $payment_gateway, $total)
    {
        $charge = $this->findPaymentCharges($payment_method, $payment_gateway);

        if($charge == $convertPercentage)

        $paymentChargeAmount = $paymentCharge->amount_gateway_charge +  $paymentCharge->amount_company_charge;
            $paymentChargePercentage = $paymentCharge->percentage_gateway_charge +  $paymentCharge->percentage_company_charge;
            $convertPercentage = $paymentChargePercentage / 100;
            $fee = $total * $convertPercentage;
    }

}