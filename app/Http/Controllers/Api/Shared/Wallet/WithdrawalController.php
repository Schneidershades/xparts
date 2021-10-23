<?php

namespace App\Http\Controllers\Api\Shared\Wallet;

use App\Models\Wallet;
use Illuminate\Support\Str;
use App\Models\PaymentCharge;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\WithdrawalCreateFormRequest;

class WithdrawalController extends Controller
{    
    /**
     * @OA\Post(
     *      path="api/v1/shared/withdrawals",
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
        $wallet = Wallet::where('user_id', auth()->user()->id)->first();

        $balance = $wallet->balance;
        
        if($balance < $request->amount ){
            return $this->errorResponse('Insufficient funds', 409);
        }

        $paymentCharge = PaymentCharge::where('payment_method_id', $request->payment_method_id)
                                ->where('gateway', $request->payment_gateway)
                                ->first();
        $fee = 0;
        
        if($paymentCharge){
            $paymentChargeAmount = $paymentCharge->amount_gateway_charge + $paymentCharge->amount_company_charge;
            $paymentChargePercentage = $paymentCharge->percentage_gateway_charge + $paymentCharge->percentage_company_charge;
            $convertPercentage = $paymentChargePercentage/100;
            $fee = $request->amount * $convertPercentage;
        }

        $order = auth()->user()->orders()->create([
            'payment_method_id' => 1,
            'title' => 'Fund Withdrawals',
            'details' => 'Fund Withdrawals',
            'user_id' => auth()->user()->id,
            'payment_charge_id' => $paymentCharge ? $paymentCharge->id : null,
            'subtotal' => $request['amount'],
            'total' => $request['amount'] + $fee,
            'transaction_type' => 'debit',
        ]);

        $wallet = $this->debitUserWallet($order, auth()->user()->id);

        $this->walletTransaction($order, $wallet, 'debit', 'orders', 'pending approval from admin');

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


    public function walletTransaction($order, $wallet, $transaction_type, $polymorphic_type, $remarks)
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
        $transaction->status = $order->status;
        $transaction->remarks = $order->status;
        $transaction->balance = $wallet->balance;
        $transaction->walletable_id = $order->id;
        $transaction->walletable_type = $polymorphic_type;
        $transaction->save();

        return $transaction;
    }
}
