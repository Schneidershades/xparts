<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'connect' => $this->connect,
            'stage' => $this->stage,
            'type' => $this->type,
            'payment_gateway' => $this->payment_gateway,
            'public_key' => $this->public_key,
        ];
    }
}