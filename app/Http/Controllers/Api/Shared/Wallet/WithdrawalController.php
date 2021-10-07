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

        WalletTransaction::create([
            'receipt_number' => $order->receipt_number,
            'title' => $order->title,
            'user_id' => $wallet->user->id,
            'details' => $order->details,
            'amount' => $order->subtotal,
            'amount_paid' => $order->total,
            'category' => $order->transaction_type,
            'transaction_type' => 'debit',
            'status' => 'pending',
            'remarks' => 'pending approval from admin',
            'balance' => $wallet->balance,
            'walletable_id' => $order->id,
            'walletable_type' => 'orders',
        ]);

        return $this->showOne($order);
    }
}
