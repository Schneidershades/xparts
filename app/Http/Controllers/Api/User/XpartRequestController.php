<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class XpartRequestController extends Controller
{
    public function index()
    {
        return $this->showAll(auth()->user()->xpartRequests);
    }

    public function store(Request $request)
    {
        return $this->showOne(auth()->user()->xpartRequests->create($request->validated()));
    }

    public function show($id)
    {
        return $this->showOne(auth()->user()->xpartRequests->where('id', $id)->with('vendorQuotes')->first());
    }
}
