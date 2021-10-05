<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Payment\PaymentChargeResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Payment\PaymentChargeCollection;

class PaymentCharge extends Model
{
    use HasFactory;

    public $oneItem = PaymentChargeResource::class;
    public $allItems = PaymentChargeCollection::class;
}
