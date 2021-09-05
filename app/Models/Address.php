<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Address\AddressCollection;

class Address extends Model
{
    use HasFactory;
    
    public $oneItem = AddressResource::class;
    public $allItems = AddressCollection::class;
}
