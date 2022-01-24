<?php

namespace App\Http\Resources\Cart;

use App\Models\DeliveryRate;
use App\Http\Resources\Cart\CartResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $deliveryFee = DeliveryRate::where('type', 'flat')->first() ? DeliveryRate::where('type', 'flat')->first()->amount : 0;

        $total = $this->collection->sum(function ($cart) {
            return $cart->cartable->markup_price * $cart->quantity;
        });

        return [
            'data' => CartResource::collection($this->collection),
            
            'cart' => [

                'total' => $total ,

                'subtotal' => $total + $deliveryFee,

                'discount' => 0,

                'delivery_fee' => $deliveryFee,
                
                'cartCount' => CartResource::collection(auth()->user()->cart)->count(),
            ],
        ];
    }
}
