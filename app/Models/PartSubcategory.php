<?php

namespace App\Models;

use App\Models\PartCategory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Part\PartSubcategoryResource;
use App\Http\Resources\Part\PartSubcategoryCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartSubcategory extends Model
{
    use HasFactory;
    
    public $oneItem = PartSubcategoryResource::class;
    public $allItems = PartSubcategoryCollection::class;

    public function partCategory()
    {
        return $this->belongsTo(PartCategory::class);
    }
}
