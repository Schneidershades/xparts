<?php

namespace App\Http\Controllers\Api\General\Part;

use App\Http\Controllers\Controller;
use App\Models\PartCategory;

class PartCategoryController extends Controller
{
    public function index()
    {
        return $this->showAll(PartCategory::all());
    }
}
