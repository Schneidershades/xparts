<?php

namespace App\Http\Resources\Pricing;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MarkupPricingCollection extends ResourceCollection
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
            'data' => MarkupPricingResource::collection($this->collection),
        ];
    }
}
