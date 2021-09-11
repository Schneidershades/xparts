<?php

namespace App\Models;

use App\Models\Vin;
use App\Models\Part;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\CategoryThreePart;
use App\Models\XpartRequestVendorWatch;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Xpart\XpartRequestResource;
use App\Http\Resources\Xpart\XpartRequestCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class XpartRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'vin_id',
        'part_id'
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
}
