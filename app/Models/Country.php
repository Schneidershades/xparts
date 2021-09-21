<?php

namespace App\Models;

use App\Http\Resources\Location\CountryCollection;
use App\Http\Resources\Location\CountryResource;
use Illuminate\Database\Eloquent\Model;

/**
* @property int $id
* @property string $name
* @property string $slug
* @property string $description
* @property \DateTime $createdAt
* @property \DateTime $updatedAt
*/
class Country extends Model
{
    public $oneItem = CountryResource::class;
    public $allItems = CountryCollection::class;

    public $timestamps = true;

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
