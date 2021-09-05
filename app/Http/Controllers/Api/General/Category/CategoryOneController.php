<?php

namespace App\Http\Controllers\Api\General\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryOne;

class CategoryOneController extends Controller
{
    public function index()
    {
        return $this->showAll(CategoryOne::all());
    }
}
