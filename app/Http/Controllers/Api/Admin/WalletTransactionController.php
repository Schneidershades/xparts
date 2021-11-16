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

        $amount_to_pay = $request['amount'] + $request['charge'];

        if($request['transaction_type'] == 'debit' && $user->wallet->balance < $amount_to_pay){
            return $this->errorResponse('insufficient funds', 409);
        }

        $wallet = WalletTransaction::create([
            'receipt_number' => 'WT-'.substr(str_shuffle("0123456789"), 0, 6),
            'title' => 'Admin ',
            'user_id' => $user->id,
            'details' => $request['details'],
            'amount' => $request['amount'],
            'amount_paid' => $amount_to_pay,
            'category' => $request['transaction_type'],
            'transaction_type' => $request['transaction_type'],
            'remarks' => $request['details'],
            'balance' => $user->wallet->balance,
            'payment_method' => $request['payment_method'],
            'admin_id' => auth()->user()->id,
        ]);

        return $this->showOne($wallet);
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

        $initiatedWallet = $wallet = false;
        $margin = 0;

        if($transaction->status != 'pending'){
            return $this->showMessage('This transaction is already '.$transaction->status);
        }

        if($request['status'] == 'declined'){
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
                return $this->errorResponse('insufficient funds', 409);
            }

            $wallet->balance = $wallet->balance - $transaction->amount_paid;
            $wallet->save();
        }


        $transaction->approving_admin_id =  auth()->user()->id;
        // $transaction->payment_method =  '';
        $transaction->status = $request['status'];
        $transaction->balance = $wallet->balance;
        $transaction->save();

        Order::create([
            'title' => 'Admin Fund Transaction Payment',
            'receipt_number' => $transaction->receipt_number,
            'details' => $transaction->details,
            'payment_method_id' => $request['payment_method_id'],
            'subtotal' => $transaction->amount,
            'total' => $transaction->amount,
            'amount_paid' => $transaction->amount_paid,
            'transaction_type' => $transaction->transaction_type,
            'margin' => $transaction->amount_paid - $transaction->amount,
            'currency' => 'NGN',
            'payment_method' => $transaction->payment_method,
            'payment_gateway' => 'admin',
            'payment_reference' => $transaction->receipt_number,
            'payment_gateway_charge' => 0,
            'payment_message' => 'payment successful',
            'payment_status' => 'successful',
            'platform_initiated' => 'inapp',
            'transaction_initiated_date' => Carbon::now(),
            'transaction_initiated_time' => Carbon::now(),
            'date_time_paid' => Carbon::now(),
            'status' => $request['status'],
            'service_status' => $request['status'],
            'orderable_type' => 'WalletTransaction',
            'orderable_id' => $transaction->id,
            
        ]);
        
        return $this->showMessage('This transaction has been '.$request['status']);
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
