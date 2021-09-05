<?php

namespace App\Http\Controllers\Api\General\Part;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PartCondition;

class PartConditionController extends Controller
{
    public function index()
    {
        return $this->showAll(PartCondition::all());
    }
}
