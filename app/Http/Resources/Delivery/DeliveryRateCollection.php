<?php

namespace App\Http\Resources\Delivery;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DeliveryRateCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => DeliveryRateResource::collection($this->collection)
        ];
    }
}
