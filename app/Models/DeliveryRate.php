<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Delivery\DeliveryRateResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Delivery\DeliveryRateCollection;

class DeliveryRate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $oneItem = DeliveryRateResource::class;
    public $allItems = DeliveryRateCollection::class;
}
