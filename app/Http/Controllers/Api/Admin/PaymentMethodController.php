<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentMethodCreateFormRequest;
use App\Http\Requests\Admin\PaymentMethodUpdateFormRequest;

class PaymentMethodController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/payment-methods",
    *      operationId="allPaymentMethods",
    *      tags={"Admin"},
    *      summary="allPaymentMethods",
    *      description="allPaymentMethods",
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
        return $this->showAll(PaymentMethod::all());
    }

    /**
    * @OA\Post(
    *      path="/api/v1/admin/payment-methods",
    *      operationId="postPaymentMethods",
    *      tags={"Admin"},
    *      summary="Post payment-methods",
    *      description="Post payment-methods",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/PaymentMethodCreateFormRequest")
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
    public function store(PaymentMethodCreateFormRequest $request)
    {
        return $this->showOne(PaymentMethod::create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/payment-methods/{id}",
    *      operationId="showPaymentMethods",
    *      tags={"Admin"},
    *      summary="Show payment-methods",
    *      description="Show payment-methods",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="payment-methods ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      
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
        return $this->showOne(PaymentMethod::findOrFail($id));
    }

    /**
    * @OA\Put(
    *      path="/api/v1/admin/payment-methods/{id}",
    *      operationId="UserPaymentMethods",
    *      tags={"Admin"},
    *      summary="Update payment-methods",
    *      description="Update payment-methods",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="payment-methods ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/PaymentMethodUpdateFormRequest")
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
    
    public function update(PaymentMethodUpdateFormRequest $request, PaymentMethod $paymentMethod)
    {
        ($paymentMethod->update($request->validated()));
        return $this->showOne($paymentMethod);
    }

     /**
    * @OA\Delete(
    *      path="/api/v1/admin/payment-methods/{id}",
    *      operationId="deletePaymentMethods",
    *      tags={"Admin"},
    *      summary="Delete payment-methods",
    *      description="Delete payment-methods",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="payment-methods ID",
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
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return $this->showMessage('deleted');
    }
}
