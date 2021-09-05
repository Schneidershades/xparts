<?php

namespace App\Models;

use App\Models\Part;
use App\Models\CategoryThree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Category\CategoryThreePartResource;
use App\Http\Resources\Category\CategoryThreePartCollection;

class CategoryThreePart extends Model
{
    use HasFactory;

    public $oneItem = CategoryThreePartResource::class;
    public $allItems = CategoryThreePartCollection::class;

    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    public function categoryThree()
    {
        return $this->belongsTo(CategoryThree::class);
    }
}
