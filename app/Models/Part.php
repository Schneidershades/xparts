<?php

namespace App\Models;

use App\Models\XpartRequest;
use App\Models\CategoryThreePart;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Part\PartResource;
use App\Http\Resources\Part\PartCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Api\QueryFieldSearchScope;

class Part extends Model
{
    use HasFactory, QueryFieldSearchScope;

    public $searchables = ['name'];

    public $guarded = [];

    public $oneItem = PartResource::class;
    public $allItems = PartCollection::class;

    public function categoryThreeParts()
    {
        return $this->hasMany(CategoryThreePart::class);
    }

    public function xpartRequests()
    {
        return $this->hasMany(XpartRequest::class);
    }
}
