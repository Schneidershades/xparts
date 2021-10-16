<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkupPricing extends Model
{
    use HasFactory;
    
    public $oneItem = MarkupPricingResource::class;
    public $allItems = MarkupPricingCollection::class;

    protected $fillable = ['min_value', 'max_value', 'percentage', 'active', 'type'];
}
