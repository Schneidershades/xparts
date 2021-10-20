<?php

namespace App\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminWalletUpdateFormRequest;

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
        return $this->showAll(WalletTransaction::latest()->get());
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/wallet-transactions/{id}",
    *      operationId="showWalletTransactions",
    *      tags={"Admin"},
    *      summary="showWalletTransactions",
    *      description="showWalletTransactions",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="WalletTransactions Receipt number",
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
        return $this->showOne(WalletTransaction::where('receipt_number', $id)->first());
    }

     /**
    * @OA\Put(
    *      path="/api/v1/admin/wallet-transactions/{id}",
    *      operationId="updateWalletTransactions",
    *      tags={"Admin"},
    *      summary="updateWalletTransactions",
    *      description="updateWalletTransactions",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="WalletTransactions Receipt Number ",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/AdminWalletUpdateFormRequest")
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
    
    public function update(AdminWalletUpdateFormRequest $request, $id)
    {
        $order = Order::where('receipt_number', $id)->first();

        $wallet = Wallet::where('user_id', $order->user_id)->first();

        $wallet->balance = $wallet->balance - $order->total;
        $wallet->save();

        $data = [
            'currency' => 'NGN',
            'payment_method' => 'wallet',
            'payment_gateway' => 'wallet',
            'payment_reference' => $order->receipt_number,
            'payment_gateway_charge' => 0,
            'payment_message' => 'payment successful',
            'payment_status' => 'successful',
            'platform_initiated' => 'inapp',
            'transaction_initiated_date' => Carbon::now(),
            'transaction_initiated_time' => Carbon::now(),
            'date_time_paid' => Carbon::now(),
            'status' => 'approved',
            'service_status' => 'approved',
        ];

        $order->update($request->validated());

        $this->debitUserWallet($order, $wallet);
        
        return $this->showOne($order);
    }

    public function debitUserWallet($order, $wallet)
    {
        $transaction = WalletTransaction::where('receipt_number', $order->receipt_number)->first();

        $transaction->update([
            'receipt_number' => $order->receipt_number,
            'title' => $order->title,
            'user_id' => $wallet->user->id,
            'details' => $order->details,
            'amount' => $order->subtotal,
            'amount_paid' => $order->total,
            'category' => $order->transaction_type,
            'transaction_type' => 'debit',
            'status' => $order->status,
            'remarks' => $order->status,
            'balance' => $wallet->balance,
            'walletable_id' => $order->id,
            'walletable_type' => 'orders',
        ]);

    }
}
