<?php

namespace App\Models;

use App\Models\CouponTransaction;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Coupon\CouponResource;
use App\Http\Resources\Coupon\CouponCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    public $guarded = [];

	public $oneItem = CouponResource::class;
	public $allItems = CouponCollection::class;
    
    public function couponTransactions()
    {
    	return $this->hasMany(CouponTransaction::class);
    }
}
