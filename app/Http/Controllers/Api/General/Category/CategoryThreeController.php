<?php

namespace App\Http\Controllers\Api\General\Category;

use App\Http\Controllers\Controller;
use App\Models\CategoryThree;

class CategoryThreeController extends Controller
{
    public function index()
    {
        return $this->showAll(CategoryThree::all());
    }
}
