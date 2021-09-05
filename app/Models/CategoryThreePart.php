<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Category\CategoryThreePartResource;
use App\Http\Resources\Category\CategoryThreePartCollection;

class CategoryThreePart extends Model
{
    use HasFactory;

    public $oneItem = CategoryThreePartResource::class;
    public $allItems = CategoryThreePartCollection::class;
}
