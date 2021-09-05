<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Xpart\XpartRequestVendorWatchResource;
use App\Http\Resources\Xpart\XpartRequestVendorWatchCollection;

class XpartRequestVendorWatch extends Model
{
    use HasFactory;
    
    public $oneItem = XpartRequestVendorWatchResource::class;
    public $allItems = XpartRequestVendorWatchCollection::class;
}
