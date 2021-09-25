<?php

namespace App\Http\Controllers\Api\Order;

use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Http\Requests\Order\OrderCreateFormRequest;
use App\Http\Requests\Order\OrderUpdateFormRequest;

class OrderController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/orders",
    *      operationId="orders",
    *      tags={"User"},
    *      summary="orders",
    *      description="orders",
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
        return $this->showAll(auth()->user()->cart);
    }

     /**
    * @OA\Post(
    *      path="/api/v1/orders",
    *      operationId="postOrders",
    *      tags={"User"},
    *      summary="postOrders",
    *      description="postOrders",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/OrderCreateFormRequest")
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

    public function store(OrderCreateFormRequest $request)
    {
        $cartSum = CartResource::collection(auth()->user()->cart)->sum('total');

        return($cartSum);

        
        // $order = auth()->user()->orders()->create([
        //     'address_id' => $request->address_id,
        //     'subtotal' => $cartSum,
        //     'total' => $cartSum,
        // ]);
        
        // collect($request->cart)->each(function ($cart) use ($order){
        //     OrderItem::create([
        //         'itemable_id'=> $cart['itemable_id'],
        //         'itemable_type'=> $cart['itemable_id'],
        //         'quantity'=> $cart['quantity'],
        //         'order_id'=> $order->id,
        //     ]);
        // });

        // auth()->user()->cart()->delete();
        
        // return $this->showOne(Order::findOrfail($order->id));
        
    }

    /**
    * @OA\Get(
    *      path="/api/v1/orders/{id}",
    *      operationId="showOrders",
    *      tags={"User"},
    *      summary="showOrders",
    *      description="showOrders",
     *      @OA\Parameter(
     *          name="id",
     *          description="Order ID",
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
        return $this->showOne(auth()->user()->orders->where('id', $id)->first());
    }

    /**
    * @OA\Put(
    *      path="/api/v1/orders/{id}",
    *      operationId="updateOrders",
    *      tags={"User"},
    *      summary="updateOrders",
    *      description="updateOrders",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/OrderUpdateFormRequest")
    *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Addresses ID",
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
    public function update(OrderUpdateFormRequest $request, $id)
    {
        $payment_status = match($request->payment_gateway){
            'paystack' => 1,
            'flutterwave' => 2,
        };
        // return $this->showOne(auth()->user()->cart->where('id', $id)->first()->update($request->validated()));
    }
}
