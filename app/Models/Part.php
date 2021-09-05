<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Part\PartResource;
use App\Http\Resources\Part\PartCollection;

class Part extends Model
{
    use HasFactory;

    public $oneItem = PartResource::class;
    public $allItems = PartCollection::class;
}
