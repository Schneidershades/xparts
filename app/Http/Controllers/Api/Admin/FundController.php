<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class FundController extends Controller
{
    public function index()
    {
        return $this->showAll(WalletTransaction::all());
    }
}
