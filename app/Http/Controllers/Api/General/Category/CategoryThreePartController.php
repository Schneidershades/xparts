<?php

namespace App\Http\Controllers\Api\General\Category;

use App\Http\Controllers\Controller;
use App\Models\CategoryThreePart;

class CategoryThreePartController extends Controller
{
    public function index()
    {
        return $this->showAll(CategoryThreePart::all());
    }
}
