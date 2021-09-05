<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Category\CategoryOneResource;
use App\Http\Resources\Category\CategoryOneCollection;

class CategoryOne extends Model
{
    use HasFactory;
    public $oneItem = CategoryOneResource::class;
    public $allItems = CategoryOneCollection::class;
}
