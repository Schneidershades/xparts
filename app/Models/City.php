<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\Country;
use App\Http\Resources\Location\CityResource;
use App\Traits\Api\QueryFieldSearchScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
* @property int $id
* @property string $name
* @property string $slug
* @property string $description
* @property datetime $createdAt
* @property datetime $updatedAt
*/
class City extends Model
{
    use HasFactory, QueryFieldSearchScope;
    
    public $oneItem = CityResource::class;
    public $allItems = CityResource::class;
    public $searchables = [];

    public function state()
    {
        return $this->belongsto(State::class);
    }

    public function country()
    {
        return $this->belongsto(Country::class);
    }

    public function cityDeliveryRate()
    {
        return $this->morphMany(DeliveryRate::class, 'destinatable');
    }
}
