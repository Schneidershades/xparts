<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return $this->showAll(auth()->user()->cart);
    }

    public function store(Request $request)
    {
        return $this->showOne(auth()->user()->cart->create($request->validated()));
    }

    public function update(Request $request, $id)
    {
        return $this->showOne(auth()->user()->cart->update($request->validated()));
    }

    public function destroy(Request $request, $id)
    {
        auth()->user()->cart->where('id', $id)->first()->delete();
        return $this->showMessage('Model deleted');
    }
}
