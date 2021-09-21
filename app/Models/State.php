<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\Country;
use App\Http\Resources\Location\StateResource;
use App\Http\Resources\Location\StateCollection;

class State extends Model
{
    public $oneItem = StateResource::class;
    public $allItems = StateCollection::class;

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
