<?php

use App\Models\User;
use App\Models\Quote;
use App\Models\XpartRequest;
use App\Events\VendorQuoteSent;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('send', function () {
    broadcast(new \App\Events\TestEvent());
    return "OK";
});

Route::get('/test-quote', function () {
    
    $quote = Quote::first();
    $user = User::first();
    $xpartRequest = XpartRequest::first();

//    dd($user, $xpartRequest, $quote);
    
    broadcast(new VendorQuoteSent($user, $xpartRequest, $quote));
});
