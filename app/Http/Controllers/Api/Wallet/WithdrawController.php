<?php

namespace App\Http\Controllers\Api\Wallet;

use Illuminate\Support\Str;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\FundCreateFormRequest;

class WithdrawController extends Controller
{        /**
     * @OA\Get(
     *      path="/api/v1/wallet-transactions",
     *      operationId="userWalletTransactions",
     *      tags={"User"},
     *      summary="userWalletTransactions",
     *      description="userWalletTransactions",
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
        return $this->showAll(auth()->user()->withdrawals);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/wallet-transactions",
     *      operationId="postWalletTransactions",
     *      tags={"User"},
     *      summary="postWalletTransactions",
     *      description="postWalletTransactions",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/WalletCreateFormRequest")
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
    public function store(FundCreateFormRequest $request)
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

    /**
     * @OA\Get(
     *      path="/api/v1/wallet-transactions/{id}",
     *      operationId="showWalletTransactions",
     *      tags={"User"},
     *      summary="showWalletTransactions",
     *      description="showWalletTransactions",
     *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Xpart Request ID",
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
        return $this->showOne(auth()->user()->walletTransactions->where('id', $id)->first());
    }
}
