<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;

class WalletTransactionController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/wallet-transactions",
    *      operationId="allWalletTransactions",
    *      tags={"Admin"},
    *      summary="allWalletTransactions",
    *      description="allWalletTransactions",
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
        $this->showAll(WalletTransaction::all());
    }
}
