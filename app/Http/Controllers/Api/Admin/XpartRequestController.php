<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\XpartRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class XpartRequestController extends Controller
{
    public function index()
    {
        $this->showAll(XpartRequest::all());
    }
}
