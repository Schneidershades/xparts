<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Order\OrderItemResource;
use App\Http\Resources\Order\OrderItemCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'itemable_id',
        'itemable_type',
        'quantity',
        'order_id',
    ];

    public $oneItem = OrderItemResource::class;
    public $allItems = OrderItemCollection::class;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function itemable()
    {
        return $this->morphTo();
    }
}
