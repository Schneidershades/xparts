<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartCreateFormRequest;
use App\Http\Requests\Cart\CartUpdateFormRequest;

class CartController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/cart",
    *      operationId="cart",
    *      tags={"User"},
    *      summary="cart",
    *      description="cart",
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
    *      path="/api/v1/cart",
    *      operationId="postCart",
    *      tags={"User"},
    *      summary="postCart",
    *      description="postCart",
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
    public function store(CartCreateFormRequest $request)
    {
        return $this->showOne(auth()->user()->cart()->create($request->validated()));
    }

    /**
    * @OA\Put(
    *      path="/api/v1/cart/{id}",
    *      operationId="updateCart",
    *      tags={"User"},
    *      summary="updateCart",
    *      description="updateCart",
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
    public function update(CartUpdateFormRequest $request, $id)
    {
        return $this->showOne(auth()->user()->cart->where('id', $id)->first()->update($request->validated()));
    }

    /**
    * @OA\Delete(
    *      path="/api/v1/cart/{id}",
    *      operationId="deleteCart",
    *      tags={"User"},
    *      summary="deleteCart",
    *      description="deleteCart",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Cart ID",
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
    public function destroy($id)
    {
        auth()->user()->cart->where('id', $id)->first()->delete();
        return $this->showMessage('Model deleted');
    }
}
