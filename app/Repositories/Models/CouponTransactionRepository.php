<?php

namespace App\Repositories\Models;

use App\Models\CouponTransaction;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ApplicationRepository;

class CouponTransactionRepository extends ApplicationRepository
{
    public function builder(): Builder
    {
        return CouponTransaction::query();
    }

    public function findCouponTransaction($coupon_id)
    {
        return $this->builder()->where('coupon_id', $coupon_id)->get();
    }
    
    public function countCouponTransaction($coupon_id) : int
    {
        return $this->findCouponTransaction($coupon_id)->count();
    }

}