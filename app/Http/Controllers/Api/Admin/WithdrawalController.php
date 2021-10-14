<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;

class WithdrawalController extends Controller
{
    
     /**
    * @OA\Get(
    *      path="/api/v1/admin/withdrawals",
    *      operationId="allWithdrawals",
    *      tags={"Admin"},
    *      summary="allWithdrawals",
    *      description="allWithdrawals",
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
        return $this->showAll(WalletTransaction::where('transaction_type', 'debit')->latest()->get());
    }
}
