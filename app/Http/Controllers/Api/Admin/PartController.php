<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Part;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartController extends Controller
{
    public function index()
    {
        return $this->showAll(Part::all());
    }
}
