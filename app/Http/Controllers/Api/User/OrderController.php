<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return $this->showAll(auth()->user()->orders);
    }

    public function show($id)
    {
        return $this->showOne(auth()->user()->orders->where('id', $id)->with('quoteOrders')->first());
    }
}
