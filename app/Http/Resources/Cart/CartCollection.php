<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
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
            'data' => CartResource::collection($this->collection),
            
            'cart' => [
                'total' => CartResource::collection(auth()->user()->cart)->sum('total'),
                'subtotal' => CartResource::collection(auth()->user()->cart)->sum('total'),
                'discount' => 0,
                'cartCount' => CartResource::collection(auth()->user()->cart)->count(),
            ],
        ];
    }
}
