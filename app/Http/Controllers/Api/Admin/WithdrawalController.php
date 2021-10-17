<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Order;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminWithdrawalsUpdateFormRequest;

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

     /**
    * @OA\Put(
    *      path="/api/v1/admin/withdrawals/{id}",
    *      operationId="updateWithdrawals",
    *      tags={"Admin"},
    *      summary="updateWithdrawals",
    *      description="updateWithdrawals",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="updateWithdrawals Receipt Number ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/AdminWithdrawalsUpdateFormRequest")
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
    
    public function update(AdminWithdrawalsUpdateFormRequest $request, $id)
    {
        $transaction = Order::where('receipt_number', $id)->first();
        $transaction->update($request->validated());
        return $this->showOne($transaction);
    }
}
