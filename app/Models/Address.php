<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Address\AddressCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    
    public $oneItem = AddressResource::class;
    public $allItems = AddressCollection::class;

    protected $fillable = [
        'name',
        'address',
        'state',
        'postal_code',
        'primary_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
