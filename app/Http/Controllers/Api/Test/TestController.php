<?php

namespace App\Http\Controllers\Api\Test;

use App\Models\User;
use App\Models\Quote;
use App\Models\XpartRequest;
use App\Events\VendorQuoteSent;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function sendQuote()
    {
        $quotes = Quote::where('id', 1)->first();
        $user = User::where('id', 1)->first();
        $xpartRequest = XpartRequest::where('id', 1)->first();
        
        broadcast(new VendorQuoteSent($user, $xpartRequest, $quotes));

    }
}
