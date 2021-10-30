<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Payment\PaymentMethodResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Payment\PaymentMethodCollection;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $oneItem = PaymentMethodResource::class;
    public $allItems = PaymentMethodCollection::class;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
