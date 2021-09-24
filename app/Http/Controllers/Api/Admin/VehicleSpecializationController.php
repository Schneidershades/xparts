<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VehicleSpecialization;

class VehicleSpecializationController extends Controller
{
    public function index()
    {
        $this->showAll(VehicleSpecialization::all());
    }
}
