<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Vin;
use App\Http\Controllers\Controller;

class VinController extends Controller
{
    public function index()
    {
        return $this->showAll(Vin::all());
    }
}
