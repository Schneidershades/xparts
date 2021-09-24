<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\PaymentCharge;
use App\Http\Controllers\Controller;

class PaymentChargeContoller extends Controller
{
    public function index()
    {
        $this->showAll(PaymentCharge::all());
    }
}
