<?php

namespace App\Http\Resources\Delivery;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DeliveryRateCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => DeliveryRateResource::collection($this->collection)
        ];
    }
}
