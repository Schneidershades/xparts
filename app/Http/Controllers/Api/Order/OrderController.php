<?php

namespace App\Http\Controllers\Api\Order;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\OrderItem;
use App\Models\PaymentCharge;
use App\Traits\Payment\Paystack;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Http\Requests\Order\OrderCreateFormRequest;
use App\Http\Requests\Order\OrderUpdateFormRequest;

class OrderController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/orders",
     *      operationId="orders",
     *      tags={"User"},
     *      summary="orders",
     *      description="orders",
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
        return $this->showAll(auth()->user()->orders);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/orders",
     *      operationId="postOrders",
     *      tags={"User"},
     *      summary="postOrders",
     *      description="postOrders",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/OrderCreateFormRequest")
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

    public function store(OrderCreateFormRequest $request)
    {
        $userCart = (auth()->user()->cart);

        $cartList = CartResource::collection(auth()->user()->cart);

        $total = $cartList->sum(function ($cart) {
            return $cart->cartable->price * $cart->quantity;
        });

        $paymentCharge = PaymentCharge::where('payment_method_id', $request->payment_method_id)
                                ->where('gateway', $request->payment_gateway)
                                ->first();
        $fee = 0;
        
        if($paymentCharge){
            $paymentChargeAmount = $paymentCharge->amount_gateway_charge +  $paymentCharge->amount_company_charge;
            $paymentChargePercentage = $paymentCharge->percentage_gateway_charge +  $paymentCharge->percentage_company_charge;
            $convertPercentage = $paymentChargePercentage/100;
            $fee = $total * $convertPercentage;
        }

        $order = auth()->user()->orders()->create([
            'title' => 'Bid Transaction Payment',
            'details' => 'Bid Transaction Payment',
            'address_id' => $request->address_id,
            'payment_method_id' => $request->payment_method_id,
            'payment_charge_id' => $paymentCharge ? $paymentCharge->id : null,
            'subtotal' => $total,
            'total' => $total + $fee,
            'transaction_type' => 'payments',
        ]);

        collect($userCart)->each(function ($cart) use ($order) {
            OrderItem::create([
                'itemable_id' => $cart->cartable_id,
                'itemable_type' => $cart->cartable_type,
                'quantity' => $cart->quantity,
                'order_id' => $order->id,
                'vendor_id' => $cart->cartable->vendor_id,
            ]);
        });

        auth()->user()->cart()->delete();

        return $this->showOne(Order::findOrfail($order->id));
    }

    /**
     * @OA\Get(
     *      path="/api/v1/orders/{id}",
     *      operationId="showOrders",
     *      tags={"User"},
     *      summary="showOrders",
     *      description="showOrders",
     *      @OA\Parameter(
     *          name="id",
     *          description="Order ID",
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
    public function show($id)
    {
        return $this->showOne(auth()->user()->orders->where('id', $id)->first());
    }

    /**
     * @OA\Put(
     *      path="/api/v1/orders/{id}",
     *      operationId="updateOrders",
     *      tags={"User"},
     *      summary="updateOrders",
     *      description="updateOrders",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/OrderUpdateFormRequest")
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
    public function update(OrderUpdateFormRequest $request, $id)
    {
        $order = Order::where('receipt_number', $request['payment_reference'])->first();

        $receipt = false;

        if($request->payment_gateway == "paystack" || $order->payment_method_id == 1){
            $paystack = new Paystack;
            [$status, $data] = $paystack->verify($request['payment_reference'], "order");

            if ($status != "success") {
                return $this->errorResponse($data, 400);
            } 


            $order->update($data);

            $receipt = true;
        }

        if($request['payment_gateway'] == "wallet"){

            dd($request->payment_gateway);

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
                'status' => 'approved',
                'service_status' => 'approved',
            ];


            $order->update($data);

            $user = User::where('id', auth()->user()->id)->first();
    
            $balance = $user->wallet ? $user->wallet->balance - $order->amount_paid : 0;

            $user->wallet->update(['balance' => $balance]);

            WalletTransaction::create([
                'receipt_number' => $order->receipt_number,
                'title' => $order->title,
                'user_id' => $user->id,
                'details' => $order->details,
                'amount' => $order->subtotal,
                'amount_paid' => $order->total,
                'category' => 'payment',
                'transaction_type' => 'debit',
                'status' => 'fulfilled',
                'remarks' => 'fulfilled',
                'balance' => $balance,
                'walletable_id' => $order->id,
                'walletable_type' => 'orders',
            ]);

            $receipt = true;
        }

        if($receipt == true) {
            collect($order->orderItems)->each(function ($item) use ($order) {

                $user = User::where('id', $item['vendor_id'])->first();
    
                $balance = $user->wallet ? $user->wallet->balance + $order->amount_paid : 0;
    
                $user->wallet->update(['balance' => $balance]);
    
                WalletTransaction::create([
                    'receipt_number' => $order->receipt_number,
                    'title' => 'Quote order purchase',
                    'user_id' => $user->id,
                    'details' => 'Quote order purchase',
                    'amount' => $order->subtotal,
                    'amount_paid' => $order->total,
                    'category' => 'payment',
                    'transaction_type' => 'credit',
                    'status' => 'fulfilled',
                    'remarks' => 'fulfilled',
                    'balance' => $balance,
                    'walletable_id' => $item['itemable_id'],
                    'walletable_type' => $item['itemable_type'],
                ]);
            });
    
            return $this->showOne($order);
        }        
    }
}
