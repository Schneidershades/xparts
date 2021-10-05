<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class PaymentMethod extends Model
{
    use HasFactory;

    public $oneItem = PaymentMethodResource::class;
    public $allItems = PaymentMethodCollection::class;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
