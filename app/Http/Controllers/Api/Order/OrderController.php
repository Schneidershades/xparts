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
use App\Models\Quote;
use App\Models\XpartRequestVendorWatch;

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

        // if (!$order->paymentMethod) {
        //     return $this->errorResponse('Error with payment gateway at the moment please try again later', 400);
        // } 

        $receipt = false;

        if($request['payment_gateway'] == "paystack"){
            $paystack = new Paystack;
            [$status, $data] = $paystack->verify($request['payment_reference'], "order");

            if ($status != "success") {
                return $this->errorResponse($data, 400);
            } 

            $order->update($data);

            $receipt = true;
        }

        if($request['payment_gateway'] == "wallet"){
            
            $wallet = Wallet::where('user_id', $order->user_id)->first();

            if($wallet->balance < $order->total){
                return $this->errorResponse('Insufficient funds', 409);
            }

            $wallet->balance = $wallet->balance - $order->total;
            
            $data = [
                'currency' => 'NGN',
                'payment_method' => 'wallet',
                'payment_gateway' => 'wallet',
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

            $receipt = true;
        }

        if($receipt == true){

            $findQuotes = Quote::whereIn('id', $order->orderItems->pluck('itemable_id')->toArray())->get();
            
            foreach($findQuotes as $quote){
                $quote->status = 'fulfilled';
                $quote->save();
            }        
            
            foreach($order->orderItems as $item){
                $this->creditVendors($order, $item, 'fullfilled', 'credit');
            }

            return $this->showMessage('Payment processed successfully');
        }else{
            return $this->errorResponse('An error occurred. please contact support', 403);
        }
    }

    public function walletTransaction($order, $user, $balance, $title, $category, $status, $type, $polyId, $polyType)
    {
        WalletTransaction::create([
            'receipt_number' => $order->receipt_number,
            'title' => $title,
            'user_id' => $user,
            'details' => $title,
            'amount' => $order->subtotal,
            'amount_paid' => $order->total,
            'category' => $category,
            'transaction_type' => $type,
            'status' => $status,
            'remarks' => $status,
            'balance' => $balance,
            'walletable_id' => $polyId,
            'walletable_type' => $polyType,
        ]);
    }

    public function creditVendors($order, $item, $status, $transaction_type)
    {
        $vendor = Wallet::where('user_id', $item->vendor_id)->first();
        $vendor->balance += $item->price;
        $vendor->save();

        WalletTransaction::create([
            'receipt_number' => $order->receipt_number,
            'title' => $order->title,
            'user_id' => $vendor->user->id,
            'details' => $order->details,
            'amount' => $order->subtotal,
            'amount_paid' => $order->total,
            'category' => $order->transaction_type,
            'transaction_type' => $transaction_type,
            'status' => $status,
            'remarks' => $status,
            'balance' => $vendor->balance,
            'walletable_id' => $item->itemable_id,
            'walletable_type' => $item->itemable_type,
        ]);
    }

    public function debitUserWallet($order, $wallet)
    {
        WalletTransaction::create([
            'receipt_number' => $order->receipt_number,
            'title' => $order->title,
            'user_id' => $wallet->user->id,
            'details' => $order->details,
            'amount' => $order->subtotal,
            'amount_paid' => $order->total,
            'category' => $order->transaction_type,
            'transaction_type' => 'debit',
            'status' => 'fulfilled',
            'remarks' => 'fulfilled',
            'balance' => $wallet->balance,
            'walletable_id' => $order->id,
            'walletable_type' => 'orders',
        ]);

    }

    public function vendorsUnderABid($order)
    {
        $allVendorsUnderABid = $order->orderItems->where('')->pluck('vendor_id')->toArray();
        $xpartsVendorCatelog = XpartRequestVendorWatch::whereIn('vendor', $allVendorsUnderABid)->get();

        foreach($xpartsVendorCatelog as $cat){
            $cat->status = 'expired';
        }
    }

    public function quotesUnderABid($order)
    {
        $allVendorsUnderABid = $order->orderItems->where('')->pluck('vendor_id')->toArray();
        $xpartsVendorCatelog = XpartRequestVendorWatch::whereIn('vendor', $allVendorsUnderABid)->get();

        foreach($xpartsVendorCatelog as $cat){
            $cat->status = 'expired';
        }
    }
}
