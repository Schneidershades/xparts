<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Payment\PaymentChargeResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Payment\PaymentChargeCollection;
use App\Traits\Api\QueryFieldSearchScope;

class PaymentCharge extends Model
{
    use HasFactory, QueryFieldSearchScope;

    public $oneItem = PaymentChargeResource::class;
    public $allItems = PaymentChargeCollection::class;
}
