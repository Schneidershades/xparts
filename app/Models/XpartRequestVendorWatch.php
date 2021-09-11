<?php

namespace App\Models;

use App\Models\User;
use App\Models\XpartRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Xpart\XpartRequestVendorWatchResource;
use App\Http\Resources\Xpart\XpartRequestVendorWatchCollection;

class XpartRequestVendorWatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'xpart_request_id'
    ];
    
    public $oneItem = XpartRequestVendorWatchResource::class;
    public $allItems = XpartRequestVendorWatchCollection::class;

    public function xpartRequestVendorWatch()
    {
        return $this->belongsTo(XpartRequest::class);
    }

    public function user()
    {
        return $this->belongs(User::class);
    }
}
