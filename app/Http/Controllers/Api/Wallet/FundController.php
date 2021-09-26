<?php

namespace App\Http\Controllers\Api\Wallet;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\FundCreateFormRequest;
use App\Http\Requests\Wallet\FundUpdateFormRequest;

class FundController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/funds",
     *      operationId="postFunds",
     *      tags={"User"},
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
        $transaction = auth()->user()->walletTransactions->create([
            'receipt_number' => Str::orderedUuid(),
            'title' => 'Fund',
            'details' => 'Fund',
            'amount' => $request->amount,
            'amount_paid' => $request->amount + 0,
            'category' => 'Fund',
            'remarks' => 'pending',
            'transaction_type' => 'Credit',
        ]);

        $order = auth()->user()->orders->create([
            'subtotal' => $transaction->amount,
            'total' => $transaction->amount_paid,
            'orderable_type' => $transaction->id,
            'orderable_id' => 'wallets',
        ]);

        return $this->showOne($order);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/funds/{id}",
     *      operationId="showFunds",
     *      tags={"User"},
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
    *      path="/api/v1/funds/{id}",
    *      operationId="updateFunds",
    *      tags={"User"},
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
        $payment_status = match($request->payment_gateway){
            'paystack' => 1,
            'flutterwave' => 2,
        };

        $order = Order::where('receipt_number', 'receipt_number')->first();

        if($order->orderable_type == 'wallets' || $order->status == 'fulfilled'){

            $transaction = WalletTransaction::find('id', $order->orderable_id)->first();

            $transaction->update([
                'status' => 'fulfilled',
                'balance' => auth()->user()->wallet->balance + $order->subtotal
            ]);

            auth()->user()->wallet->update([
                'balance' => auth()->user()->wallet->balance + $order->subtotal
            ]);

        }

        // return $this->showOne(auth()->user()->cart->where('id', $id)->first()->update($request->validated()));
    }

}
