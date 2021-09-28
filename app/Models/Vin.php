<?php

namespace App\Models;

use App\Http\Resources\Vin\VinResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Vin\VinCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vin extends Model
{
    use HasFactory;
    public $oneItem = VinResource::class;
    public $allItems = VinCollection::class;

    protected $appends = ['vehicle_name'];

    public function getVehicleNameAttribute()
    {
        return "{$this->model_year} {$this->make} {$this->model}";
    }
}
