<?php

namespace App\Models;

use App\Models\CouponTransaction;
use App\Traits\Api\QueryFieldSearchScope;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Coupon\CouponResource;
use App\Http\Resources\Coupon\CouponCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory,QueryFieldSearchScope;

    public $guarded = [];

	public $oneItem = CouponResource::class;
	public $allItems = CouponCollection::class;

    public function couponTransactions()
    {
    	return $this->hasMany(CouponTransaction::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
