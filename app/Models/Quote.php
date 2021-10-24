<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\User;
use App\Models\PartGrade;
use App\Models\XpartRequest;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Quote\QuoteResource;
use App\Http\Resources\Quote\QuoteCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
    use HasFactory;

    protected $guarded = [];

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

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }

    public function markupPricing()
    {
        return $this->belongsTo(MarkupPricing::class);
    }

    public function images()
    {
        return $this->morphMany(Media::class, 'fileable');
    }
}
