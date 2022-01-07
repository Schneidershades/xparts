<?php

namespace App\Repositories\Models;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ApplicationRepository;

class CouponRepository extends ApplicationRepository
{
    public function builder(): Builder
    {
        return Coupon::query();
    }

    public function findCouponCode($code)
    {
        return $this->builder()->where('code', $code)->first();
    }

}