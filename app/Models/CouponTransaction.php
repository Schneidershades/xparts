<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Coupon\CouponTransactionResource;
use App\Http\Resources\Coupon\CouponTransactionCollection;

class CouponTransaction extends Model
{
    use HasFactory;

    public $guarded = [];

    public $oneItem = CouponTransactionResource::class;
    public $allItems = CouponTransactionCollection::class;
    
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function coupon()
    {
    	return $this->belongsTo(Coupon::class);
    }
}
