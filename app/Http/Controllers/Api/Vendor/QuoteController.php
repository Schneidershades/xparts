<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index()
    {
        return $this->showAll(auth()->user()->quotes);
    }

    public function store(Request $request)
    {
        return $this->showOne(auth()->user()->quotes->create($request->validated()));
    }

    public function show($id)
    {
        return $this->showOne(auth()->user()->quotes->where('id', $id)->first());
    }

    public function update(Request $request, $id)
    {
        return $this->showOne(auth()->user()->quotes->update($request->validated()));
    }

    public function destroy(Request $request, $id)
    {
        auth()->user()->quotes->where('id', $id)->first()->delete();
        return $this->showMessage('Model deleted');
    }
}
