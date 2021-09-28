<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentChargeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'charge' => $this->charge(),
        ];
    }

    public function charge()
    {
        $paymentChargeAmount = $this->amount_gateway_charge +  $this->amount_company_charge;
        $paymentChargePercentage = $this->percentage_gateway_charge +  $this->percentage_company_charge;
        return $paymentChargePercentage.'% + N'.$paymentChargeAmount;
    }
}
