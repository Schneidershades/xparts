<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Page\PageResource;
use App\Http\Resources\Page\PageCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;
    
    public $guarded = [];

    public $oneItem = PageResource::class;
    public $allItems = PageCollection::class;
}
