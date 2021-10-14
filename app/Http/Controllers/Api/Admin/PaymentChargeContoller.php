<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\PaymentCharge;
use App\Http\Controllers\Controller;

class PaymentChargeContoller extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/payment-charges",
    *      operationId="allPaymentCharge",
    *      tags={"Admin"},
    *      summary="allPaymentCharge",
    *      description="allPaymentCharge",
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
        return $this->showAll(PaymentCharge::all());
    }
}
