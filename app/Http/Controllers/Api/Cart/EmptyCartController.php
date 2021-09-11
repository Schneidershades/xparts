<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;

class EmptyCartController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/empty-cart",
    *      operationId="emptyCart",
    *      tags={"User"},
    *      summary="emptyCart",
    *      description="emptyCart",
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
    public function index()
    {
        return $this->showMessage(auth()->user()->cart()->delete());
    }
}
