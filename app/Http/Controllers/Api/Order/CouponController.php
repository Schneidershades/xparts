<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function store(Request $request)
    {
        $cartList = CartResource::collection(auth()->user()->cart);

        $coupon = Coupon::where('code', $request['code'])->first();

        if($coupon == null){
    		return $this->errorResponse('coupon is not available', 400);
    	}

        if($coupon->no_of_users != null){
            if($coupon->no_of_users <= $coupon->couponTransactions->count()){
                return $this->errorResponse('number of users exceeded on this coupon', 400);
            }
        }

        // if($coupon->amount != null){
        //     $couponAmount = $coupon->amount;
        //     $total = $request[''] - $coupon->amount;
        // }

        // if($coupon->percentage != null){
        //     $coupon = $coupon->percentage / 100;

        //     $couponAmount = $this->cart->subtotal() * $coupon;
        //     $total = $this->cart->subtotal() - $couponAmount;
        // }

    }
}
