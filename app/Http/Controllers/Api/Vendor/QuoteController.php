<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Vendor\QuoteCreateFormRequest;

class QuoteController extends Controller
{
    public function index()
    {
        return $this->showAll(auth()->user()->quotes);
    }

    public function store(QuoteCreateFormRequest $request)
    {
        return $this->showOne(auth()->user()->quotes->create($request->validated()));
    }

    public function show($id)
    {
        return $this->showOne(auth()->user()->quotes->where('id', $id)->first());
    }

    public function destroy(Request $request, $id)
    {
        auth()->user()->quotes->where('id', $id)->first()->delete();
        return $this->showMessage('Model deleted');
    }
}
