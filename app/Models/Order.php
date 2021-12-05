<?php

namespace App\Models;

use App\Models\User;
use App\Models\Address;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Models\DeliveryRate;
use App\Models\PaymentCharge;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\OrderCollection;
use App\Traits\Api\QueryFieldSearchScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, QueryFieldSearchScope;

    public $searchables = [];

    protected $fillable = [
        'address_id',
        'user_id',
        'total',
        'subtotal',
        'payment_method',
        'amount_paid',
        'currency',
        'payment_method_id',
        'payment_gateway',
        'payment_reference',
        'payment_gateway_charge',
        'payment_message',
        'payment_status',
        'transaction_initiated_date',
        'transaction_initiated_time',
        'date_time_paid',
        'orderable_type',
        'orderable_id',
        'transaction_type',
        'service_status',
        'status',
        'title',
        'details',
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

    public function paymentCharge()
    {
        return $this->belongsTo(PaymentCharge::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function deliveryRate()
    {
        return $this->belongsTo(DeliveryRate::class);
    }

    public function relatedTransactionReferences()
    {
        return $this->hasMany(OrderItem::class)->where('receipt_number', $this->payment_reference);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->receipt_number = 'XR-'. substr(str_shuffle("0123456789"), 0, 6);
        });
    }
}

