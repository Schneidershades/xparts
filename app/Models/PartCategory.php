<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Part\PartCategoryResource;
use App\Http\Resources\Part\PartCategoryCollection;

class PartCategory extends Model
{
    use HasFactory;

    public $oneItem = PartCategoryResource::class;
    public $allItems = PartCategoryCollection::class;
}
