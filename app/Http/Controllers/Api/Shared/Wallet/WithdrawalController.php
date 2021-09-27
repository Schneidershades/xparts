<?php

namespace App\Http\Controllers\Api\Wallet\Shared;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\WithdrawalCreateFormRequest;

class WithdrawalController extends Controller
{    
    /**
     * @OA\Post(
     *      path="/api/v1/shared/withdrawals",
     *      operationId="postWithdrawals",
     *      tags={"Shared"},
     *      summary="postWithdrawals",
     *      description="postWithdrawals",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/WithdrawalCreateFormRequest")
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
    public function store(WithdrawalCreateFormRequest $request)
    {
        if(auth()->user()->wallet->balance >= $request->amount ){
            return $this->errorResponse('Insufficient funds', 409);
        }

        $transaction = auth()->user()->walletTransactions->create([
            'receipt_number' => Str::orderedUuid(),
            'title' => 'Withdrawal',
            'details' => 'Withdrawal',
            'amount' => $request->amount,
            'amount_paid' => $request->amount,
            'category' => 'Withdrawal',
            'remarks' => 'pending',
            'transaction_type' => 'Debit',
        ]);

        return $this->showOne($transaction);
    }
}
