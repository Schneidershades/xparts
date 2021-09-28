<?php

namespace App\Http\Controllers\Api\Shared;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/shared/payment-methods",
    *      operationId="paymentMethods",
    *      tags={"location"},
    *      summary="paymentMethods",
    *      description="paymentMethods",
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\MediaType(
    *             mediaType="application/json",
    *         ),
    *       ),
    * )
    */
    public function index()
    {
        return $this->showAll(PaymentMethod::all());
    }
}
