<?php

namespace App\Models;

use App\Models\User;
use App\Models\Address;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\OrderCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;


    protected $fillable = [
        'address_id',
        'total',
        'subtotal',
        'payment_method',
        'orderable_type',
        'orderable_id',
    ];

    public $oneItem = OrderResource::class;
    public $allItems = OrderCollection::class;

    public function orderable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->receipt_number = Str::orderedUuid();
        });
    }
}
