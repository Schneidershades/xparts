<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Category\CategoryTwoResource;
use App\Http\Resources\Category\CategoryTwoCollection;

class CategoryTwo extends Model
{
    use HasFactory;

    public $oneItem = CategoryTwoResource::class;
    public $allItems = CategoryTwoCollection::class;
}
