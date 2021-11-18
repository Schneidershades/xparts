<?php

namespace App\Models;

use App\Models\Vin;
use App\Models\Part;
use App\Models\User;
use App\Models\Media;
use App\Models\Order;
use App\Models\Quote;
use App\Models\Address;
use App\Models\OrderItem;
use App\Models\CategoryThreePart;
use App\Models\XpartRequestVendorWatch;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Api\QueryFieldSearchScope;
use App\Http\Resources\Xpart\XpartRequestResource;
use App\Http\Resources\Xpart\XpartRequestCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    
    public $searchables = ['status'];

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

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // public function builder()
    // {
    //     return XpartRequest::query()
    //             ->selectRaw('xpart_requests.*')
    //             ->selectRaw('users.name AS user_name')
    //             ->selectRaw('parts.name AS part_name')
    //             ->selectRaw('vins.name AS vin_number')
    //             ->leftJoin('user', 'users.id', '=', 'xpart_requests.user_id')
    //             ->leftJoin('parts', 'parts.id', '=', 'xpart_requests.part_id')
    //             ->leftJoin('addresses', 'addresses.id', '=', 'xpart_requests.address_id')
    //             ->leftJoin('vins', 'vins.id', '=', 'xpart_requests.vin_id')->get();
    // }

}