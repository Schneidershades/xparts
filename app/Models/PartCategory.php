<?php

namespace App\Models;

use App\Models\PartSubcategory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Part\PartCategoryResource;
use App\Http\Resources\Part\PartCategoryCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartCategory extends Model
{
    use HasFactory;

    public $oneItem = PartCategoryResource::class;
    public $allItems = PartCategoryCollection::class;

    public function partSubcategories()
    {
        return $this->hasMany(PartSubcategory::class);
    }
}
