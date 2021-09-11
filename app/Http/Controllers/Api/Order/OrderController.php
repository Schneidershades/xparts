<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderCreateFormRequest;
use App\Http\Requests\Order\OrderUpdateFormRequest;

class OrderController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/orders",
    *      operationId="allOrders",
    *      tags={"User"},
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
    *          @OA\JsonContent(ref="#/components/schemas/CartCreateFormRequest")
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
        // return collect($products)->keyBy('id')->map(function(){
    	// 	return [
    	// 		'quantity' => $product['quantity'] + $this->getCurrentQuantity($product['id']),
    	// 	];
    	// })->toArray();
        
        // return $this->showOne(auth()->user()->orders()->create([
        //     'address_id' => $request-> ,
        //     'subtotal' => auth()->user()->cart()->sum(),
        //     'orderable_type' => $request->orderable_type,
        //     'orderable_id' => $request->orderable_type,
        // ]));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/orders/{id}",
    *      operationId="showOrders",
    *      tags={"User"},
    *      summary="showOrders",
    *      description="showOrders",
    *      
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
    *      summary="updateOrders,
    *      description="updateOrders",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/CartUpdateFormRequest")
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
        return $this->showOne(auth()->user()->cart->where('id', $id)->first()->update($request->validated()));
    }
}
