<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\PartGrade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartGradeController extends Controller
{
    public function index()
    {
        $this->showAll(PartGrade::all());
    }
}
