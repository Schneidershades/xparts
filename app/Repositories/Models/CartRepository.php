<?php

namespace App\Repositories\Models;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ApplicationRepository;

class CartRepository extends ApplicationRepository
{
    public function builder(): Builder
    {
        return Cart::query();
    }

    public function totalCartMarkup($basket) : int
    {
        return $basket->sum(function ($cart) {
            return ($cart->cartable->markup_price ?  $cart->cartable->markup_price : $cart->cartable->price) * $cart->quantity;
        });  
    }

    public function totalCartWithoutMarkup($basket) : int
    {
        return $basket->sum(function ($cart) {
            return ($cart->cartable->markup_price ?  $cart->cartable->markup_price : $cart->cartable->price) * $cart->quantity;
        });  
    }

    public function totalCartMargin($basket): int
    {
        return $this->totalCartMarkup($basket) - $this->totalCartWithoutMarkup($basket);
    }

}