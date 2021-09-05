<?php

namespace App\Http\Controllers\Api\General\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryTwo;

class CategoryTwoController extends Controller
{
    public function index()
    {
        return $this->showAll(CategoryTwo::all());
    }
}
