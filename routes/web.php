<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('send', function () {
//     broadcast(new \App\Events\TestEvent());
//     return "OK";
// });