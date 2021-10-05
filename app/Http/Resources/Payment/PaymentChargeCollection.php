<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentChargeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => PaymentChargeResource::collection($this->collection),
        ];
    }
}
