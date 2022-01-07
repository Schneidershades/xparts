<?php

namespace App\Http\Controllers\Api\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Models\CartRepository;
use App\Repositories\Models\CouponRepository;
use App\Repositories\Models\CouponTransactionRepository;

class CouponController extends Controller
{
    public $cartRepository;
    public $couponRepository;
    public $couponTransactionRepository;

    public function __construct(
        CartRepository $cartRepository, 
        CouponRepository $couponRepository, 
        CouponTransactionRepository $couponTransactionRepository
    )
    {
        $this->cartRepository = $cartRepository;
        $this->couponRepository = $couponRepository;
        $this->couponTransactionRepository = $couponTransactionRepository;
    }

    public function store(Request $request)
    {
        $coupon = $this->couponRepository->findCouponCode($request['code']);

        if($coupon == null){
    		return $this->errorResponse('coupon is not available', 400);
    	}

        if($coupon->no_of_users != null){
            if($coupon->no_of_users <= $coupon->couponTransactions->count()){
                return $this->errorResponse('number of users exceeded on this coupon', 400);
            }
        }

        $total = $this->cartRepository->totalCartMarkup(auth()->user()->cart);

        if($coupon->amount != null){
            $couponAmount = $coupon->amount;
        }

        if($coupon->percentage != null){
            $coupon = $coupon->percentage / 100;
            $couponAmount = $total * $coupon;
        }

        return $this->showMessage($couponAmount);

    }
}
