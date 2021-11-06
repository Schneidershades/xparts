<?php

namespace App\Http\Controllers\Api\Shared;

use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;

class PaymentMethodTopUpController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/shared/payment-methods-top-up",
    *      operationId="paymentMethods",
    *      tags={"Shared"},
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
        return $this->showAll(PaymentMethod::where('type', 'top-up')->get());
    }
}
