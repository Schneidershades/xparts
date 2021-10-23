<?php

namespace App\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Wallet;
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
    * @OA\Get(
    *      path="/api/v1/admin/withdrawals/{id}",
    *      operationId="showWithdrawals",
    *      tags={"Admin"},
    *      summary="showWithdrawals",
    *      description="showWithdrawals",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="showWithdrawals Receipt number",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
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

    public function show($id)
    {
        return $this->showOne(Order::where('receipt_number', $id)->first());
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
        $order = Order::where('receipt_number', $id)->first();

        if($request->status == 'declined'){
            $wallet = $this->debitUserWallet($order, auth()->user()->id);

            $this->walletTransaction(
                $order, 
                $wallet, 
                'debit', 
                'orders', 
                'transaction reversal from withdrawal action',
                'pending'
            );
        }

        $data = [
            'currency' => 'NGN',
            'payment_method' => 'wallet',
            'payment_gateway' => 'wallet',
            'payment_reference' => $order->receipt_number,
            'payment_gateway_charge' => 0,
            'payment_message' => 'payment successful',
            'payment_status' => $request->status,
            'platform_initiated' => 'inapp',
            'transaction_initiated_date' => Carbon::now(),
            'transaction_initiated_time' => Carbon::now(),
            'date_time_paid' => Carbon::now(),
            'status' => 'approved',
            'service_status' => 'approved',
        ];

        $order->update($request->validated());
        
        return $this->showOne($order);
    }

    public function debitUserWallet($order, $userId)
    {
        $wallet = Wallet::where('user_id', $userId)->first();
        $wallet->balance = $wallet->balance - $order->total;
        $wallet->save();
        return $wallet;
    }

    public function creditUserWallet($order, $userId)
    {
        $wallet = Wallet::where('user_id', $userId)->first();
        $wallet->balance = $wallet->balance + $order->total;
        $wallet->save();
        return $wallet;
    }

    public function walletTransaction($order, $wallet, $transaction_type, $polymorphic_type, $remarks, $status)
    {
        $transaction = WalletTransaction::where('receipt_number', $order->receipt_number)->first();

        if($transaction == null){
            $transaction =  new WalletTransaction;
        }
        $transaction->receipt_number = $order->receipt_number;
        $transaction->title = $order->title;
        $transaction->user_id = $wallet->user->id;
        $transaction->details = $order->details;
        $transaction->amount = $order->subtotal;
        $transaction->amount_paid = $order->total;
        $transaction->category = $order->transaction_type;
        $transaction->transaction_type = $transaction_type;
        $transaction->status = $status;
        $transaction->remarks = $remarks;
        $transaction->balance = $wallet->balance;
        $transaction->walletable_id = $order->id;
        $transaction->walletable_type = $polymorphic_type;
        $transaction->save();

        return $transaction;
    }
}
