<?php

namespace App\Http\Controllers\Api\General\Part;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PartGrade;

class PartGradeController extends Controller
{
    public function index()
    {
        return $this->showAll(PartGrade::all());
    }
}
