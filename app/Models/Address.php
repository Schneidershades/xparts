<?php

namespace App\Models;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Address\AddressCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Api\QueryFieldSearchScope;

class Address extends Model
{
    use HasFactory, QueryFieldSearchScope;
    
    public $oneItem = AddressResource::class;
    public $allItems = AddressCollection::class;

    protected $fillable = [
        'name',
        'address',
        'state',
        'postal_code',
        'primary_address',
        'city_id',
        'country_id',
        'state_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
