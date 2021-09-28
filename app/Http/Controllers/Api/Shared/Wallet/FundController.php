<?php

namespace App\Http\Controllers\Api\Shared\Wallet;

use App\Models\User;
use App\Models\Order;
use App\Models\Wallet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
        $transaction = auth()->user()->walletTransactions()->create([
            'title' => 'Fund',
            'details' => 'Fund',
            'amount' => $request['amount'],
            'amount_paid' => $request['amount'] + 0,
            'category' => 'Fund',
            'remarks' => 'pending',
            'transaction_type' => 'Credit',
        ]);
        

        $order = $transaction->orders()->create([
            'subtotal' => $transaction->amount,
            'total' => $transaction->amount_paid,
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
        $order = Order::where('orderable_id', $request['orderable_id'])
                ->where('orderable_type', $request['orderable_type'])
                ->first();

        $paystack = new Paystack;

        [$status, $data] = $paystack->verify($request['payment_reference'], "order");

        if ($status != "success") {
            return $this->errorResponse($data, 400);
            
        } 

        $order->update($data);

        $user = Wallet::where('user_id', $order->user_id)->first();
        $user->balance += $order->total;
        $user->save();

        return $this->showOne($order);
    }

}
