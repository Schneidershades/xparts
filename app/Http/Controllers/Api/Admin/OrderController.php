<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Order;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/orders",
    *      operationId="allOrders",
    *      tags={"Admin"},
    *      summary="allOrders",
    *      description="allOrders",
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
        return $this->showAll(Order::latest()->get());
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/orders/{id}",
    *      operationId="showOrders",
    *      tags={"Admin"},
    *      summary="showOrders",
    *      description="showOrders",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Order Receipt number",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
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

    public function show($id)
    {
        return $this->showOne(Order::where('receipt_number', $id));
    }
}
