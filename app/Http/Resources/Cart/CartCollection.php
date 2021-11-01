<?php

namespace App\Http\Resources\Cart;

use App\Models\Address;
use App\Http\Resources\Cart\CartResource;
use App\Models\DeliveryRate;
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
        $deliveryFee = DeliveryRate::where('type', 'flat')->first() ? DeliveryRate::where('type', 'flat')->first()->amount : 0;
        return [
            'data' => CartResource::collection($this->collection),
            
            'cart' => [

                'total' => $this->collection->sum(function ($cart) {
                    return $cart->cartable->markup_price * $cart->quantity;
                }),

                'subtotal' => $this->collection->sum(function ($cart) {
                    return $cart->cartable->markup_price * $cart->quantity;
                }),

                'discount' => 0,

                'delivery_fee' => $deliveryFee,
                
                'cartCount' => CartResource::collection(auth()->user()->cart)->count(),
            ],
        ];
    }
}
