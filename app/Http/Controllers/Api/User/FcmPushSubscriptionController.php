<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreFcmPushSubscriptionRequest;

class FcmPushSubscriptionController extends Controller
{
    public function store(StoreFcmPushSubscriptionRequest $request)
    {
        return auth()->user()->fcmPushSubscriptions->create($request->all());
    }
}
