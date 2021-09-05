<?php

namespace App\Http\Controllers\Api\Share;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        return $this->showAll(auth()->user()->addresses);
    }

    public function store(Request $request)
    {
        return $this->showMessage(auth()->user()->addresses->create($request->validated()));
    }

    public function destroy($id)
    {
        auth()->user()->addresses->where('id', $id)->first()->delete();
        return $this->showMessage('the address has been deleted');
    }
}
