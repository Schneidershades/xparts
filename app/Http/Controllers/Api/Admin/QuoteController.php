<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Quote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuoteController extends Controller
{
    public function index()
    {
        $this->showAll(Quote::all());
    }
}
