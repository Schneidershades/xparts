<?php

namespace App\Http\Controllers\Api\Shared\Wallet;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Wallet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PaymentCharge;
use App\Traits\Payment\Paystack;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\FundCreateFormRequest;
use App\Http\Requests\Wallet\FundUpdateFormRequest;

class FundController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/shared/funds",
     *      operationId="postFunds",
     *      tags={"Shared"},
     *      summary="postFunds",
     *      description="postFunds",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/FundCreateFormRequest")
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
        $paymentCharge = PaymentCharge::where('payment_method_id', $request->payment_method_id)
                                ->where('gateway', $request->payment_gateway)
                                ->first();
        $fee = 0;
        
        if($paymentCharge){
            $paymentChargeAmount = $paymentCharge->amount_gateway_charge + $paymentCharge->amount_company_charge;
            $paymentChargePercentage = $paymentCharge->percentage_gateway_charge + $paymentCharge->percentage_company_charge;
            $convertPercentage = $paymentChargePercentage/100;
            $fee = $request['amount'] * $convertPercentage;
        }

        $order = auth()->user()->orders()->create([
            'payment_method_id' => 1,
            'user_id' => auth()->user()->id,
            'payment_charge_id' => 2,
            'subtotal' => $request['amount'],
            'total' => $request['amount'] + $fee,
            'transaction_type' => 'credit',
        ]);
        
        return $this->showOne($order);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/shared/funds/{id}",
     *      operationId="showFunds",
     *      tags={"Shared"},
     *      summary="showFunds",
     *      description="showFunds",
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

    /**
    * @OA\Put(
    *      path="/api/v1/shared/funds/{id}",
    *      operationId="updateFunds",
    *      tags={"Shared"},
    *      summary="updateFunds",
    *      description="updateFunds",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/FundUpdateFormRequest")
    *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Addresses ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
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
    public function update(FundUpdateFormRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        $receipt = false;

        if($order->payment_gateway == 'paystack'){
            $paystack = new Paystack;
            [$status, $data] = $paystack->verify($request['payment_reference'], "order");

            if ($status != "success") {
                return $this->errorResponse($data, 400);
            } 

            $receipt = true;

            $order->update($data);
        }

        if($request->payment_gateway == "wallet" || $order->payment_method_id == 2){

            if(auth()->user()->wallet->balance >= $request->amount ){
                return $this->errorResponse('Insufficient funds', 409);
            }

            $wallet = Wallet::where('user_id', $order->user_id)->first();
            $wallet->balance -= $order->total;
            $wallet->save();

            $data = [
                'currency' => 'NGN',
                'payment_method' => 'wallet',
                'payment_gateway' => "wallet",
                'payment_reference' => $request['payment_reference'],
                'payment_gateway_charge' => 0,
                'payment_message' => 'payment successful',
                'payment_status' => 'successful',
                'platform_initiated' => 'inapp',
                'transaction_initiated_date' => Carbon::now(),
                'transaction_initiated_time' => Carbon::now(),
                'date_time_paid' => Carbon::now(),
            ];

            $receipt = true;

            $order->update($data);
        }

        if($receipt == true){

            $user = User::where('id', auth()->user()->id)->first();
    
            $balance = $user->wallet ? $user->wallet->balance + $order->amount_paid : 0;

            $user->wallet->update(['balance' => $balance]);

            WalletTransaction::create([
                'receipt_number' => $order->receipt_number,
                'title' => 'Fund Wallet Account',
                'user_id' => $user->id,
                'details' => 'Fund Wallet Account',
                'amount' => $order->total,
                'amount_paid' => $order->amount_paid,
                'category' => 'Fund',
                'transaction_type' => $order->transaction_type,
                'status' => 'fulfilled',
                'remarks' => 'fulfilled',
                'balance' => $balance,
                'walletable_id' => $order->id,
                'walletable_type' => 'orders',
            ]);
        }

        return $this->showOne($order);
    }

}
