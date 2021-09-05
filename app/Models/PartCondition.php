<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Part\PartConditionResource;
use App\Http\Resources\Part\PartConditionCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartCondition extends Model
{
    use HasFactory;
    
    public $oneItem = PartConditionResource::class;
    public $allItems = PartConditionCollection::class;
}
