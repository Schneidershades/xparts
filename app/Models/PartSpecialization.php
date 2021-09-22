<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Part\PartSpecializationResource;
use App\Http\Resources\Part\PartSpecializationCollection;

class PartSpecialization extends Model
{
    use HasFactory;
    
    public $oneItem = PartSpecializationResource::class;
    public $allItems = PartSpecializationCollection::class;
}
