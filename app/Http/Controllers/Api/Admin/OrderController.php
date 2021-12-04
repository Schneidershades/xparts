<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Models\OrderRepository;

class OrderController extends Controller
{
    public $orderRepo;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

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
        return $this->showAll($this->orderRepo->all());
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
     *              type="string"
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
        return $this->showOne(Order::where('receipt_number', $id)->first());
    }
}
