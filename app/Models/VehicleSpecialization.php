<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Vehicle\VehicleSpecializationResource;
use App\Http\Resources\Vehicle\VehicleSpecializationCollection;

class VehicleSpecialization extends Model
{
    use HasFactory;

    public $oneItem = VehicleSpecializationResource::class;
    public $allItems = VehicleSpecializationCollection::class;
}
