<?php

namespace App\Http\Controllers\Api\General\Part;

use App\Models\PartSubcategory;
use App\Http\Controllers\Controller;

class PartSubcategoryController extends Controller
{
    public function index()
    {
        return $this->showAll(PartSubcategory::all());
    }
}
