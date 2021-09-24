<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\PartSpecialization;
use App\Http\Controllers\Controller;

class PartSpecializationController extends Controller
{
    public function index()
    {
        $this->showAll(PartSpecialization::all());
    }
}
