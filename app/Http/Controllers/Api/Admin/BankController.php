<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;

class BankController extends Controller
{
    public function index()
    {
        return $this->showAll(Bank::all());
    }
}
