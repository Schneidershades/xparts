<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Category\CategoryThreeResource;
use App\Http\Resources\Category\CategoryThreeCollection;

class CategoryThree extends Model
{
    use HasFactory;
    public $oneItem = CategoryThreeResource::class;
    public $allItems = CategoryThreeCollection::class;
}
