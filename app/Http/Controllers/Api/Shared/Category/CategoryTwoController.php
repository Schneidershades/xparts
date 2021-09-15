<?php

namespace App\Http\Controllers\Api\Shared\Category;

use App\Http\Controllers\Controller;
use App\Models\CategoryTwo;

class CategoryTwoController extends Controller
{
    public function index()
    {
        return $this->showAll(CategoryTwo::all());
    }
}