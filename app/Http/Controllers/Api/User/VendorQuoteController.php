<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorQuoteController extends Controller
{
    public function show($id)
    {
        return $this->showOne(auth()->user()->xpartRequests->where('id', $id)->first());
    }
}
