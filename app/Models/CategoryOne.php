<?php

namespace App\Models;

use App\Models\CategoryTwo;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Category\CategoryOneResource;
use App\Http\Resources\Category\CategoryOneCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryOne extends Model
{
    use HasFactory;
    public $oneItem = CategoryOneResource::class;
    public $allItems = CategoryOneCollection::class;

    public function categoryTwos()
    {
        return $this->hasMany(CategoryTwo::class);
    }
}
