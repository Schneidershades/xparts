<?php

namespace App\Models;

use App\Models\Vin;
use App\Models\Part;
use App\Models\User;
use App\Models\Quote;
use App\Models\OrderItem;
use App\Models\CategoryThreePart;
use App\Models\XpartRequestVendorWatch;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Xpart\XpartRequestResource;
use App\Http\Resources\Xpart\XpartRequestCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Api\QueryFieldSearchScope;

class XpartRequest extends Model
{
    use HasFactory, QueryFieldSearchScope;

    protected $fillable = [
        'vin_id',
        'part_id',
        'status',
    ];
    
    public $oneItem = XpartRequestResource::class;
    public $allItems = XpartRequestCollection::class;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    public function categoryThree()
    {
        return $this->belongsTo(CategoryThreePart::class);
    }

    public function vin()
    {
        return $this->belongsTo(Vin::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function xpartWatchRequests()
    {
        return $this->hasMany(XpartRequestVendorWatch::class);
    }

    public function vendorQuotes()
    {
        return $this->hasMany(Quote::class)->where('vendor_id', '!=', auth()->user()->id);
    }

    public function allQuotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function images()
    {
        return $this->morphMany(Media::class, 'fileable');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
