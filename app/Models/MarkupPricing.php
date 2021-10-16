<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Pricing\MarkupPricingResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Pricing\MarkupPricingCollection;

class MarkupPricing extends Model
{
    use HasFactory;
    
    public $oneItem = MarkupPricingResource::class;
    public $allItems = MarkupPricingCollection::class;

    protected $fillable = ['min_value', 'max_value', 'percentage', 'active', 'type'];
}
