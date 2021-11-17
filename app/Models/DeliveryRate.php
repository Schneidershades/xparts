<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Delivery\DeliveryRateResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Delivery\DeliveryRateCollection;
use App\Traits\Api\QueryFieldSearchScope;

class DeliveryRate extends Model
{
    use HasFactory, QueryFieldSearchScope;

    protected $guarded = [];
    public $searchables = [];

    public $oneItem = DeliveryRateResource::class;
    public $allItems = DeliveryRateCollection::class;
}
