<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Part\PartGradeResource;
use App\Http\Resources\Part\PartGradeCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartGrade extends Model
{
    use HasFactory;
    
    public $oneItem = PartGradeResource::class;
    public $allItems = PartGradeCollection::class;
}
