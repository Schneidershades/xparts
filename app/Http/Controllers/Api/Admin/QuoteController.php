<?php

namespace App\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Quote;
use App\Models\Wallet;
use App\Models\OrderItem;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminQuoteUpdateFormRequest;

class QuoteController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/quotes",
    *      operationId="allQuotes",
    *      tags={"Admin"},
    *      summary="allQuotes",
    *      description="allQuotes",
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
        return $this->showAll(Quote::latest()->get());
    }

     /**
    * @OA\Put(
    *      path="/api/v1/admin/quotes/{id}",
    *      operationId="updateQuotes",
    *      tags={"Admin"},
    *      summary="updateQuotes",
    *      description="updateQuotes",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="updateQuotes ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/AdminQuoteUpdateFormRequest")
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
    
    public function update(AdminQuoteUpdateFormRequest $request, $id)
    {
        $orderItem = null;

        $quote = Quote::where('id', $id)->first();

        if(!$quote){
            return $this->errorResponse('Quote not found', 404);
        }

        if($quote->status == $request['status']){
            return $this->errorResponse('Quote already '. $request['status'], 409);
        }

        $order = Order::where('receipt_number',  $quote->receipt_number)->first();

        $orderItem = $this->findOrderItemsForQuotesSelected($order, $quote);

        if(!$orderItem){
            return $this->errorResponse('Quote order item not found. Please contact support', 404);
        }

        if($request['status'] == "refunded" && $quote->status == "delivered" || $quote->status == "paid" ){

            $this->debitVendorsOrderItemBasedOnPriceNotMarkupPrice($order, $orderItem, $quote, 'successful', 'debit');

            $this->refundUserOrderItemBasedOnMarkupPrice($order, $orderItem, $quote, 'successful', 'credit');

            $orderItem->status = $request['status'];

            $orderItem->save();
        }

        if($request['status'] == "delivered"){
            if($orderItem->status == 'pending' || $orderItem->status == 'ordered'){
                $this->creditVendors($order, $orderItem, $quote, 'successful', 'credit');
            }
        }

        $quote->status = $request['status'];
        $quote->save();

        $orderItem->status = $request['status'];
        $orderItem->save();

        $xpartRequest = $orderItem->itemable->xpartRequest;
        $xpartRequest->status = $quote->status;
        $xpartRequest->save();

        return $this->showOne($quote);
    }

    public function findOrderItemsForQuotesSelected($order, $quote)
    {
        $item = OrderItem::where('receipt_number', $quote->receipt_number)
            ->where('order_id', $order->id)
            ->where('itemable_id', $quote->id)
            ->where('itemable_type', 'quotes')
            ->first();

        return $item;
    }

    public function creditVendors($order, $orderItemDetails, $bid, $status, $transaction_type)
    {
        $quantityPurchased = $orderItemDetails->quantity;
        $vendorBalance = Wallet::where('user_id', $bid->vendor_id)->first();
        $item_total = $bid->price * $quantityPurchased;
        $vendorBalance->balance = $vendorBalance->balance + $item_total;
        $vendorBalance->save();

        $product =  $orderItemDetails->itemable_type ? $orderItemDetails->itemable->title : $orderItemDetails->itemable_type;

        if($orderItemDetails->itemable_type == 'quotes'){
            $title = "Refunding users for $product transaction payment";
            $details = "Refunding users for $product transaction payment";;
        }

        $newOrder = $this->createOrder($vendorBalance, $title, $details, $order, $transaction_type);

        $this->createOrderItem($newOrder, $orderItemDetails);

        $this->createTransaction($newOrder, $vendorBalance, $item_total, $orderItemDetails, $status, $transaction_type);
    }

    public function debitVendorsOrderItemBasedOnPriceNotMarkupPrice($order, $orderItemDetails, $bid, $status, $transaction_type)
    {
        $quantityPurchased = $orderItemDetails->quantity;
        $vendorBalance = Wallet::where('user_id', $bid->vendor_id)->first();
        $item_total = $bid->price * $quantityPurchased;

        if ($vendorBalance->balance < $item_total) {
            return $this->errorResponse('Insufficient funds', 409);
        }

        $vendorBalance->balance = $vendorBalance->balance - $item_total;
        $vendorBalance->save();

        $order->amount_paid = $order->amount_paid - $bid->price;
        $order->total = $order->total -  $bid->price;
        $order->subtotal = $order->subtotal -  $bid->price;
        $order->save();

        $product =  $orderItemDetails->itemable_type ? $orderItemDetails->itemable->title : $orderItemDetails->itemable_type;

        if($orderItemDetails->itemable_type == 'quotes'){
            $title = "Refunding users for $product transaction payment";
            $details = "Refunding users for $product transaction payment";;
        }

        $newOrder = $this->createOrder($vendorBalance, $title, $details, $order, $transaction_type);

        $this->createOrderItem($newOrder, $orderItemDetails);

        $this->createTransaction($newOrder, $vendorBalance, $item_total, $orderItemDetails, $status, $transaction_type);
    }

    public function refundUserOrderItemBasedOnMarkupPrice($order, $orderItemDetails, $bid, $status, $transaction_type)
    {
        $quantityPurchased = $orderItemDetails->quantity;
        $userBalance = Wallet::where('user_id', $order->user_id)->first();
        $item_total = $bid->markup_price * $quantityPurchased;
        $userBalance->balance = $userBalance->balance - $item_total;
        $userBalance->save();

        $product =  $orderItemDetails->itemable_type ? $orderItemDetails->itemable->title : $orderItemDetails->itemable_type;

        if($orderItemDetails->itemable_type == 'quotes'){
            $title = "Refunding users for $product transaction payment";
            $details = "Refunding users for $product transaction payment";;
        }

        $newOrder = $this->createOrder($userBalance, $title, $details, $order, $transaction_type);

        $this->createOrderItem($newOrder, $orderItemDetails);

        $this->createTransaction($newOrder, $userBalance, $item_total, $orderItemDetails, $status, $transaction_type);
    }

    public function createOrderItem($newOrder, $orderItemDetails)
    {
        OrderItem::create([
            'itemable_id' => $orderItemDetails->itemable_id,
            'itemable_type' => $orderItemDetails->itemable_type,
            'quantity' => $orderItemDetails->quantity,
            'order_id' => $newOrder->id,
            'receipt_number' => $newOrder->receipt_number,
            'vendor_id' => $orderItemDetails->vendor_id,
        ]);
    }

    public function createTransaction($newOrder, $userBalance, $item_total, $orderItemDetails, $status, $transaction_type)
    {
        WalletTransaction::create([
            'receipt_number' => $newOrder->receipt_number,
            'title' => $newOrder->title,
            'user_id' => $userBalance->user->id,
            'details' => $newOrder->details,
            'amount' => $item_total,
            'amount_paid' => $item_total,
            'category' => $newOrder->transaction_type,
            'transaction_type' => $transaction_type,
            'status' => $status,
            'remarks' => $status,
            'balance' => $userBalance->balance,
            'walletable_id' => $orderItemDetails->itemable_id,
            'walletable_type' => $orderItemDetails->itemable_type,
        ]);
    }

    public function createOrder($userBalance, $title, $details, $order, $transaction_type)
    {
        return $userBalance->user->orders()->create([
            'title' => $title,
            'details' => $details,
            'receipt_number' => $order->receipt_number,
            'address_id' => $order->address_id,
            'payment_method_id' => $order->payment_method_id,
            'payment_charge_id' => $order->payment_charge_id,
            'subtotal' => $order->subtotal,
            'total' => $order->total,
            'amount_paid' => $order->amount_paid,
            'transaction_type' => $transaction_type,
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
    }
    
}
