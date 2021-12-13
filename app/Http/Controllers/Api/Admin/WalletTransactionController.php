<?php

namespace App\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminWalletCreateFormRequest;
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
    * @OA\Post(
    *      path="/api/v1/admin/wallet-transactions",
    *      operationId="postPart",
    *      tags={"Admin"},
    *      summary="postPart",
    *      description="postPart",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/AdminWalletCreateFormRequest")
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
    public function store(AdminWalletCreateFormRequest $request)
    {
        $user = User::find($request['user_id']);

        $wallet = null;

        $amount_to_pay = $request['amount'] + $request['charge'];

        if($request['transaction_type'] == 'debit' && $user->wallet->balance < $amount_to_pay){
            return $this->errorResponse('Insufficient funds', 409);
        }

        $order = Order::create([
            'payment_method_id' => 1,
            'title' => 'Fund Withdrawals',
            'action' => 'transfer',
            'details' => $request['details'],
            'user_id' => $user->id,
            'subtotal' => $request['amount'],
            'total' => $request['amount'] ,
            'currency' => 'NGN',
            'margin' => $amount_to_pay - $request['amount'],
            'amount_paid' => $amount_to_pay,
            'transaction_type' => $request['transaction_type'],
            'payment_method' => 'wallet',
            'payment_gateway' => 'wallet',
            'payment_gateway_charge' => 0,
            'payment_message' => 'pending',
            'payment_status' => 'pending',
            'platform_initiated' => 'inapp',
            'transaction_initiated_date' => Carbon::now(),
            'transaction_initiated_time' => Carbon::now(),
            'date_time_paid' => Carbon::now(),
            'status' => 'pending',
            'service_status' => 'pending',
            'orderable_type' => 'WalletTransaction',
        ]);

        if($request['transaction_type'] == 'debit'){
            $this->debitUserWallet($order, $user->id);
        }

        $transaction = $this->walletTransaction(
            $order, 
            $user->wallet, 
            $request['transaction_type'], 
            'orders', 
            'pending approval from admin',
            'pending'
        );

        return $this->showOne($transaction);
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
        $transaction = WalletTransaction::where('receipt_number', $id)->first();

        $order = Order::where('receipt_number', $id)->first();

        if(!$transaction){
            return $this->showMessage('Transaction receipt number not found');
        }

        $initiatedWallet = $wallet = false;
        $margin = 0;

        if($transaction->status != 'pending'){
            return $this->showMessage('This transaction is already '.$transaction->status);
        }

        if($request['status'] == 'declined'){
            $transaction->remarks = $request['remarks'] ? $request['remarks'] : null;
            $transaction->status = $request['status'];
            $transaction->save();
            return $this->showMessage('This transaction has been '.$request['status']);
        }

        if($request['status'] == $transaction->status){
            return $this->showMessage('This transaction has already been '.$request['status']);
        }

        if($transaction->transaction_type == 'credit'){
            $wallet = Wallet::where('user_id', $transaction->user_id)->first();
            $wallet->balance = $wallet->balance + $transaction->amount_paid;
            $wallet->save();
        }

        if($transaction->transaction_type == 'debit'){
            $wallet = Wallet::where('user_id', $transaction->user_id)->first();

            if($wallet->balance < $transaction->amount_paid){
                return $this->errorResponse('Insufficient funds', 409);
            }

            $wallet->balance = $wallet->balance - $transaction->amount_paid;
            $wallet->save();
        }

        $transaction->approving_admin_id =  auth()->user()->id;
        $transaction->remarks = $request['remarks'] ? $request['remarks'] : null;
        $transaction->status = $request['status'];
        $transaction->balance = $wallet->balance;
        $transaction->save();

        $order::update([
            'payment_reference' => $transaction->receipt_number,
            'payment_gateway_charge' => 0,
            'payment_message' => 'payment successful',
            'payment_status' => 'successful',
            'platform_initiated' => 'inapp',
            'transaction_initiated_date' => Carbon::now(),
            'transaction_initiated_time' => Carbon::now(),
            'date_time_paid' => Carbon::now(),
            'status' => 'approved',
            'service_status' => 'approved',
            'orderable_type' => 'WalletTransaction',
            'orderable_id' => $transaction->id,
        ]);
        
        return $this->showMessage('This transaction has been '.$request['status']);
    }

    public function debitUserWallet($order, $userId)
    {
        $wallet = Wallet::where('user_id', $userId)->first();
        $wallet->balance = $wallet->balance - $order->amount_paid;
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
        $transaction->amount_paid = $order->amount_paid;
        $transaction->category = $order->transaction_type;
        $transaction->transaction_type = $transaction_type;
        $transaction->status = $order->status;
        $transaction->remarks = $remarks;
        $transaction->balance = $wallet->balance;
        $transaction->walletable_id = $order->id;
        $transaction->walletable_type = $polymorphic_type;
        $transaction->save();

        return $transaction;
    }
}
