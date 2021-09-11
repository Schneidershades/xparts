<?php

namespace App\Models;

use App\Cart\Cart;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Quote\QuoteResource;
use App\Http\Resources\Quote\QuoteCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
    use HasFactory;
    
    public $oneItem = QuoteResource::class;
    public $allItems = QuoteCollection::class;

    public function cart()
    {
        return $this->morphMany(Cart::class, 'cartable');
    }

    public function xpartRequest()
    {
        return $this->belongsTo(XpartRequest::class);
    }

    public function partGrade()
    {
        return $this->belongsTo(PartGrade::class);
    }

    public function partCategory()
    {
        return $this->belongsTo(PartCategory::class);
    }

    public function partSubcategory()
    {
        return $this->belongsTo(PartSubcategory::class);
    }

    public function partCondition()
    {
        return $this->belongsTo(PartCondition::class);
    }

}