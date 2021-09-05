<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Order\OrderItemResource;
use App\Http\Resources\Order\OrderItemCollection;

class OrderItems extends Model
{
    use HasFactory;

    public $oneItem = OrderItemResource::class;
    public $allItems = OrderItemCollection::class;
}
