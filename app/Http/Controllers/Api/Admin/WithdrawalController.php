<?php

namespace App\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\BankDetail;
use App\Traits\Payment\Paystack;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Admin\AdminFinalizeTransferFormRequest;
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
        $search_query = request()->get('search') ? request()->get('search') : null;

        if(!$search_query){
            return $this->showAll(WalletTransaction::where('transaction_type', 'debit')->latest()->get());
        }
        
        $item = WalletTransaction::query()
            ->selectRaw('wallet_transactions.*')
            ->where('wallet_transactions.transaction_type', 'debit')
            ->leftJoin('users', 'users.id', '=', 'wallet_transactions.user_id')
            ->when($search_query, function (Builder $builder, $search_query) {
                $builder->where('wallet_transactions.receipt_number', 'LIKE', "%{$search_query}%")
                ->orWhere('users.name', 'LIKE', "%{$search_query}%")
                ->orWhere('users.email', 'LIKE', "%{$search_query}%")
                ->orWhere('users.phone', 'LIKE', "%{$search_query}%")
                ->orWhere('wallet_transactions.id', 'LIKE', "%{$search_query}%")
                ->orWhere('wallet_transactions.title', 'LIKE', "%{$search_query}%")
                ->orWhere('wallet_transactions.balance', 'LIKE', "%{$search_query}%");
            })->latest()->get();
        return $this->showAll($item);
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
    *          description="uOrdernauthenticated",
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
     *              type="string"
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

        if($order->payment_status == 'approved' || $order->status == 'approved' || $order->status == 'refunded' || $order->status == 'declined'){
            return $this->errorResponse("Transfer already processed as $order->status", 409);
        }

        if($request['status'] == 'declined' || $request['status'] == 'refunded'){

            $order->status = $request['status']; 
            $order->payment_status = $request['status']; 
            $order->service_status = $request['status']; 
            $order->save();
            
            $wallet = $this->creditUserWallet($order,  $order->user_id);

            $this->walletTransaction(
                $order, 
                $wallet, 
                'credit', 
                'orders', 
                'transaction reversal from withdrawal action',
                'refunded'
            );

            return $this->showMessage('Transaction has been declined and reversed');  
        }

        $user = User::where('id', $order->user_id)->first();

        return $this->intiateMoneyToBankAccount($user, $order);
    }

    public function debitUserWallet($order, $userId)
    {
        $wallet = Wallet::where('user_id', $userId)->first();
        $wallet->balance = $wallet->balance - $order->amount_paid;
        $wallet->save();
        return $wallet;
    }

    public function creditUserWallet($order, $userId)
    {
        $wallet = Wallet::where('user_id', $userId)->first();
        $wallet->balance = $wallet->balance + $order->amount_paid;
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

    public function intiateMoneyToBankAccount($user, $order)
    {        
        $bankDetail = BankDetail::where('user_id', $user->id)->first();
        $paystack = new Paystack;

        if($bankDetail == null){
            return $this->errorResponse('Bank account details not found. Please contact customer', 409);            
        }

        $responseDetails = $paystack->createTransferReceipient($bankDetail);

        if($responseDetails['status'] == false){
            $order->payment_status = "failed"; 
            $order->payment_gateway_remarks = $responseDetails['message']; 
            $order->save();

            return $this->errorResponse($responseDetails['message'], 409);  
        }

        $createdResponse = $paystack->initiateTransfer($bankDetail, $order->total, $responseDetails['paystack_recipient_code']);

        if($createdResponse['status'] == false){
            $order->payment_status = "failed"; 
            $order->payment_gateway_remarks = $createdResponse['message']; 
            $order->save();

            return $this->errorResponse($createdResponse['message'], 409);  
        }

        $order->payment_gateway_remarks = $createdResponse['message']; 
        $order->payment_recipient_code = $createdResponse['payment_recipient_code']; 
        $order->payment_transfer_code = $createdResponse['payment_transfer_code']; 
        $order->payment_transfer_status = $createdResponse['payment_transfer_status']; 
        $order->payment_gateway = "paystack";
        $order->save();

        return $this->showOne($order);  
    }


     /**
    * @OA\post(
    *      path="/api/v1/admin/withdrawals/finalize",
    *      operationId="finalizeWithdrawals",
    *      tags={"Admin"},
    *      summary="finalizeWithdrawals",
    *      description="finalizeWithdrawals",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/AdminFinalizeTransferFormRequest")
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
    public function paystackPaymentFinalize(AdminFinalizeTransferFormRequest $request)
    {
        $order = Order::where('receipt_number', $request['receipt_number'])->first();

        if($order->payment_status == 'approved' || $order->status == 'approved' || $order->status == 'refunded' || $order->status == 'declined'){
            return $this->errorResponse("Transfer already processed as $order->status", 409);
        }

        $paystack = new Paystack;
        $verificationResponse = $paystack->finalizeTransfer($order, $request['otp']);

        if($verificationResponse['status'] == false){
            $order->payment_gateway_remarks = $verificationResponse['message']; 
            $order->save();

            return $this->errorResponse($order->payment_gateway_remarks, 409);
        }

        $order->payment_gateway_remarks = $verificationResponse['message']; 
        $order->payment_reference = $verificationResponse['payment_reference']; 
        $order->save();

        $data = [
            'currency' => 'NGN',
            'payment_method' => 'wallet',
            'payment_reference' => $order->receipt_number,
            'payment_gateway_charge' => 0,
            'payment_message' => 'payment successful',
            'platform_initiated' => 'inapp',
            'transaction_initiated_date' => Carbon::now(),
            'transaction_initiated_time' => Carbon::now(),
            'date_time_paid' => Carbon::now(),
            'status' => 'approved',
            'payment_status' => 'approved',
            'service_status' => 'approved',
        ];

        $order->update($data);

        return $this->showMessage($order);
        
    }


    /**
    * @OA\Get(
    *      path="/api/v1/admin/withdrawals/verify/{receipt_number}",
    *      operationId="verifyWithdrawals",
    *      tags={"Admin"},
    *      summary="verifyWithdrawals",
    *      description="verifyWithdrawals",
    *      
     *      @OA\Parameter(
     *          name="receipt_number",
     *          description="verifyWithdrawals Receipt Number ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
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
    public function paystackVerifyTransferPayment($receipt_number)
    {
        $order = Order::where('receipt_number', $receipt_number)->first();

        if($order->payment_status == 'approved' || $order->status == 'approved' || $order->status == 'refunded' || $order->status == 'declined'){
            return $this->errorResponse('Transfer already initiated', 409);
        }

        $paystack = new Paystack;

        return $verificationResponse = $paystack->verifyTransfer($order->payment_reference);

        if($verificationResponse['status'] == false){
            $order->payment_gateway_remarks = $verificationResponse['message']; 
            $order->save();

            return $this->errorResponse($order->payment_gateway_remarks, 409);
        }

        $order->payment_gateway_remarks = $verificationResponse['message']; 
        $order->save();

        return $this->showMessage($order->payment_gateway_remarks);
        
    }
}
