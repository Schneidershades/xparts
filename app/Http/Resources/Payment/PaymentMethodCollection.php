<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentMethodCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => PaymentMethodResource::collection($this->collection),
        ];
    }
}
