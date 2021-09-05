<?php

namespace App\Models;

use App\Models\CategoryOne;
use App\Models\CategoryThree;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Category\CategoryTwoResource;
use App\Http\Resources\Category\CategoryTwoCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryTwo extends Model
{
    use HasFactory;

    public $oneItem = CategoryTwoResource::class;
    public $allItems = CategoryTwoCollection::class;

    public function categoryOne()
    {
        return $this->belongsTo(CategoryOne::class);
    }

    public function categoryThrees()
    {
        return $this->hasMany(CategoryThree::class);
    }
}
