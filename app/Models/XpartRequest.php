<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Xpart\XpartRequestResource;
use App\Http\Resources\Xpart\XpartRequestCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class XpartRequest extends Model
{
    use HasFactory;
    
    public $oneItem = XpartRequestResource::class;
    public $allItems = XpartRequestCollection::class;
}
}
