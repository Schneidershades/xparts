<?php

namespace App\Models;

use App\Models\XpartRequest;
use App\Models\CategoryThreePart;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Part\PartResource;
use App\Http\Resources\Part\PartCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Part extends Model
{
    use HasFactory;

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

    public function scopeFilter($query)
    {
        $query->where('name', 'like', '%' . request('search') . '%');
    }
}
