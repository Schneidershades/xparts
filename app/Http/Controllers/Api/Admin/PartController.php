<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Part;
use App\Http\Controllers\Controller;

class PartController extends Controller
{
    public function index()
    {
        return $this->showAll(Part::all());
    }
}
