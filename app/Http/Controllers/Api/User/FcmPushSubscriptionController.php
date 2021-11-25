<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreFcmPushSubscriptionRequest;

class FcmPushSubscriptionController extends Controller
{

    /**
     * @OA\Post(
     *      path="/api/v1/fcm-token-subcriptions",
     *      operationId="postFcmTokenSubscriptions",
     *      tags={"User"},
     *      summary="postFcmTokenSubscriptions",
     *      description="postFcmTokenSubscriptions",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreFcmPushSubscriptionRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful signin",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      security={ {"bearerAuth": {}} },
     * )
     */

    public function store(StoreFcmPushSubscriptionRequest $request)
    {
        return $this->showOne(auth()->user()->fcmPushSubscriptions()->create($request->all()));
    }
}
