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

}
