<?php

namespace App\Models;

use App\Models\CategoryTwo;
use App\Models\CategoryThreePart;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Category\CategoryThreeResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Category\CategoryThreeCollection;

class CategoryThree extends Model
{
    use HasFactory;
    public $oneItem = CategoryThreeResource::class;
    public $allItems = CategoryThreeCollection::class;

    public function categoryTwo()
    {
        return $this->belongsTo(CategoryTwo::class);
    }

    public function categoryThreeParts()
    {
        return $this->hasMany(CategoryThreePart::class);
    }
}
