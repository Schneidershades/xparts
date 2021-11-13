<?php

namespace App\Http\Controllers\Api\Order;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Quote;
use App\Models\Wallet;
use App\Jobs\SendEmail;
use App\Models\OrderItem;
use App\Models\DeliveryRate;
use App\Models\XpartRequest;
use App\Models\PaymentCharge;
use App\Models\PaymentMethod;
use App\Traits\Payment\Paystack;
use App\Models\WalletTransaction;
use App\Mail\Vendor\XpartQuoteMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\XpartRequestVendorWatch;
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
            return ($cart->cartable->markup_price ?  $cart->cartable->markup_price : $cart->cartable->price) * $cart->quantity;
        });

        if($total <= 0){
            return $this->errorResponse('An error occoured while processing your cart totals', 400);
        }

        $paymentCharge = PaymentCharge::where('payment_method_id', $request['payment_method_id'])
            ->where('gateway', $request['payment_gateway'])
            ->first();
            
        $fee = 0;

        $deliverySetting = DeliveryRate::where('type', 'flat')->first();
        if ($deliverySetting) {
            $fee = $fee + $deliverySetting->amount;
        }

        if ($paymentCharge) {
            $paymentChargeAmount = $paymentCharge->amount_gateway_charge +  $paymentCharge->amount_company_charge;
            $paymentChargePercentage = $paymentCharge->percentage_gateway_charge +  $paymentCharge->percentage_company_charge;
            $convertPercentage = $paymentChargePercentage / 100;
            $fee = $total * $convertPercentage;
        }

        $order = auth()->user()->orders()->create([
            'title' => 'Bid Transaction Payment',
            'details' => 'Bid Transaction Payment',
            'address_id' => $request['address_id'],
            'payment_method_id' => $request['payment_method_id'],
            'payment_charge_id' => $paymentCharge ? $paymentCharge->id : null,
            'delivery_setting_id' => $deliverySetting ? $deliverySetting->id : null,
            'subtotal' => $total,
            'total' => $total + $fee,
            'amount_paid' => $total + $fee,
            'transaction_type' => 'payments',
        ]);

        collect($userCart)->each(function ($cart) use ($order) {
            OrderItem::create([
                'itemable_id' => $cart->cartable_id,
                'itemable_type' => $cart->cartable_type,
                'quantity' => $cart->quantity,
                'order_id' => $order->id,
                'receipt_number' => $order->receipt_number,
                'vendor_id' => $cart->cartable->vendor_id,
            ]);
        });

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

        $paymentMethod = PaymentMethod::where('id', $request['payment_method_id'])->first();

        if($paymentMethod == null){
            return $this->errorResponse('Payment method was not sent. Please select a payment method', 409);
        }

        if($order == null){
            return $this->errorResponse('Transaction reference not found', 409);
        }

        if($order->status == 'paid' || $order->status == 'ordered' || $order->payment_status == 'successful'){
            return $this->errorResponse('This transaction has already been initiated', 409);
        }

        $status = $payment_message = $payment_method = $payment_gateway = $payment_status = null;

        if ($paymentMethod->name == "Payment on Delivery") {
            $status = 'ordered';
            $payment_message = 'payment on delivery';
            $payment_method = 'pay on delivery';
            $payment_gateway = 'pay on delivery';
            $payment_status = 'pending';
        }


        if ($paymentMethod->name == "Card" && $paymentMethod->payment_gateway == "paystack") {
            $paystack = new Paystack;
            [$status, $data] = $paystack->verify($request['payment_reference'], "order");

            if ($status != "success") {
                return $this->errorResponse($data, 400);
            }

            $status = 'paid';
            $payment_message = 'payment successful';
            $payment_method = 'wallet';
            $payment_gateway = 'wallet';
            $payment_status = 'successful';
        }

        if ($paymentMethod->name == "Wallet") {

            $wallet = Wallet::where('user_id', $order->user_id)->first();

            if ($wallet->balance < $order->total) {
                return $this->errorResponse('Insufficient funds', 409);
            }

            $wallet->balance = $wallet->balance - $order->total;
            $wallet->save();

            $this->debitUserWallet($order, $wallet);

            $status = 'paid';
            $payment_message = 'payment successful';
            $payment_method = 'wallet';
            $payment_gateway = 'wallet';
            $payment_status = 'successful';
        }

        if ($status == null) {
            return $this->errorResponse('An error occurred. please contact support', 403);
        }

        $data = [
            'currency' => 'NGN',
            'payment_method_id' => $paymentMethod->id,
            'payment_method' => $payment_method,
            'payment_gateway' => $payment_gateway,
            'payment_reference' => $request['payment_reference'],
            'payment_gateway_charge' => 0,
            'payment_message' => $payment_message,
            'payment_status' => $payment_status,
            'platform_initiated' => 'inapp',
            'transaction_initiated_date' => Carbon::now(),
            'transaction_initiated_time' => Carbon::now(),
            'date_time_paid' => Carbon::now(),
            'status' => $status,
            'service_status' => $status,
        ];

        $order->update($data);

        $findQuotes = Quote::whereIn('id', $order->orderItems->pluck('itemable_id')->toArray())->get();

        if($status == "paid"){
            foreach ($findQuotes as $bid) {
                $bid->receipt_number = $order->receipt_number;
                $bid->order_id = $order->id;
                $bid->save();
                $orderItem = $this->findOrderItemsForQuotesSelected($order, $bid, $status);
                $this->creditVendors($order, $orderItem, $bid, 'successful', 'credit');
            }
        }else{
            foreach ($findQuotes as $bid) {
                $bid->receipt_number = $order->receipt_number;
                $bid->order_id = $order->id;
                $bid->save();
                $orderItem = $this->findOrderItemsForQuotesSelected($order, $bid, $status);
            }
        }
       
        foreach ($findQuotes as $quote) {
            $quote->status = $status;
            $quote->save();

            SendEmail::dispatch($quote->vendor->email, new XpartQuoteMail($quote, $quote->vendor))->onQueue('emails')->delay(5);
        }

        $allRequestsSent = $findQuotes->pluck('xpart_request_id')->toArray();

        $userRequests = XpartRequest::whereIn('id', $allRequestsSent)->get();
        
        foreach ($userRequests as $userRequest) {
            $userRequest->receipt_number = $order->receipt_number;
            $userRequest->order_id = $order->id;
            $userRequest->status =  $status;
            $userRequest->address_id =  $order->address_id;
            $userRequest->save();
        }

        // expire the remaining activities
        $notPaidQuotesButStillActive = Quote::whereIn('xpart_request_id', $allRequestsSent)->where('status', 'active')->get();

        foreach ($notPaidQuotesButStillActive as $quote) {
            $quote->status = 'expired';
            $quote->save();
        }

        $sentRequest = XpartRequestVendorWatch::whereIn('xpart_request_id', $allRequestsSent)->get();

        foreach ($sentRequest as $sent) {
            $sent->status = 'expired';
            $sent->save();
        }

        auth()->user()->cart()->delete();

        return $this->showMessage('Order processed successfully');
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

    public function findOrderItemsForQuotesSelected($order, $quote, $status)
    {
        $item = OrderItem::where('order_id', $order->id)->where('itemable_id', $quote->id)->where('itemable_type', 'quotes')->first();
        $item->status = $status;
        $item->receipt_number = $order->receipt_number;
        $item->save();
        return $item;
    }

    public function debitWallet($order, $orderItemDetails, $bid)
    {
        $quantityPurchased = $orderItemDetails->quantity;
        $vendorBalance = Wallet::where('user_id', $bid->vendor_id)->first();
        $item_total = $bid->price * $quantityPurchased;
        $vendorBalance->balance = $vendorBalance->balance + $item_total;
        $vendorBalance->save();
    }

    public function creditVendors($order, $orderItemDetails, $bid, $status, $transaction_type)
    {
        $quantityPurchased = $orderItemDetails->quantity;
        $vendorBalance = Wallet::where('user_id', $bid->vendor_id)->first();
        $item_total = $bid->price * $quantityPurchased;
        $vendorBalance->balance = $vendorBalance->balance + $item_total;
        $vendorBalance->save();

        if($orderItemDetails->itemable_type == 'quotes'){
            $title = 'Receiving '.  $orderItemDetails->itemable_type . ' transaction payment';
            $details = 'Receiving '.  $orderItemDetails->itemable_type . ' transaction payment';
        }

        $newOrder = $vendorBalance->user->orders()->create([
            'title' => $title,
            'details' => $details,
            'receipt_number' => $order->receipt_number,
            'address_id' => $order->address_id,
            'payment_method_id' => $order->payment_method_id,
            'payment_charge_id' => $order->payment_charge_id,
            'subtotal' => $order->subtotal,
            'total' => $order->total,
            'amount_paid' => $order->amount_paid,
            'transaction_type' => 'credit',
            'currency' => 'NGN',
            'payment_reference' => $order->receipt_number,
            'payment_gateway_charge' => 0,
            'payment_message' => $details,
            'payment_status' => 'successful',
            'platform_initiated' => 'inapp',
            'transaction_initiated_date' => Carbon::now(),
            'transaction_initiated_time' => Carbon::now(),
            'date_time_paid' => Carbon::now(),
            'status' => 'paid',
            'service_status' => 'paid',
        ]);

        OrderItem::create([
            'itemable_id' => $orderItemDetails->itemable_id,
            'itemable_type' => $orderItemDetails->cartable_type,
            'quantity' => $orderItemDetails->quantity,
            'order_id' => $newOrder->id,
            'receipt_number' => $newOrder->receipt_number,
            'vendor_id' => $orderItemDetails->vendor_id,
        ]);

        WalletTransaction::create([
            'receipt_number' => $newOrder->receipt_number,
            'title' => $newOrder->title,
            'user_id' => $vendorBalance->user->id,
            'details' => $newOrder->details,
            'amount' => $item_total,
            'amount_paid' => $item_total,
            'category' => $newOrder->transaction_type,
            'transaction_type' => $transaction_type,
            'status' => $status,
            'remarks' => $status,
            'balance' => $vendorBalance->balance,
            'walletable_id' => $orderItemDetails->itemable_id,
            'walletable_type' => $orderItemDetails->itemable_type,
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
            'status' => $order->status,
            'remarks' => $order->status,
            'balance' => $wallet->balance,
            'walletable_id' => $order->id,
            'walletable_type' => 'orders',
        ]);
    }
}
