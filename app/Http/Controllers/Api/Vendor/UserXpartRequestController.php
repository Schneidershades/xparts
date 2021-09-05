<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserXpartRequestController extends Controller
{
    public function index()
    {
        return $this->showAll(auth()->user()->userXpartRequest);
    }

    public function show($id)
    {
        return $this->showOne(auth()->user()->userXpartRequest->where('id', $id)->first());
    }

    public function destroy(Request $request, $id)
    {
        auth()->user()->quotes->where('id', $id)->first()->delete();
        return $this->showMessage('Model deleted');
    }
}
