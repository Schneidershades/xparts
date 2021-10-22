<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;

class FundController extends Controller
{
    public function index()
    {
        return $this->showAll(WalletTransaction::all());
    }
}
