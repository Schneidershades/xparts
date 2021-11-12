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

        if($request['status'] == "refunded" || $quote->status == "delivered"){

            $orderItem = $this->findOrderItemsForQuotesSelected($order, $quote);
            $this->debitVendor($order, $orderItem, $quote, 'successful', 'debit');
            
        }

        $quote->status = $request['status'];

        $quote->save();

        if($quote->status == "delivered"){
            $orderItem = $this->findOrderItemsForQuotesSelected($order, $quote);

            if(!$orderItem){
                return $this->errorResponse('Quote order item not found. Please contact support', 404);
            }

            if($orderItem->status == 'pending' || $orderItem->status == 'ordered'){
                $this->creditVendors($order, $orderItem, $quote, 'successful', 'credit');
            }

            $orderItem->status = $request['status'];
            $orderItem->save();

            $xpartRequest = $orderItem->itemable->xpartRequest;

            $countDeliveredQuotes = $orderItem->itemable->xpartRequest->allQuotes->where('status', 'delivered')->count();
            $countNotDeliveredQuotes = $orderItem->itemable->xpartRequest->allQuotes->where('status', '!=', 'delivered')->count();

            if($countDeliveredQuotes > 0){
                $xpartRequest->status = $quote->status;
                $xpartRequest->save();
            }
        }

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

    public function debitVendors($order, $orderItemDetails, $bid, $status, $transaction_type)
    {
        $quantityPurchased = $orderItemDetails->quantity;
        $vendorBalance = Wallet::where('user_id', $bid->vendor_id)->first();
        $item_total = $bid->price * $quantityPurchased;
        $vendorBalance->balance = $vendorBalance->balance - $item_total;
        $vendorBalance->save();

        if($orderItemDetails->itemable_type == 'quotes'){
            $title = 'Refunding '.  $orderItemDetails->itemable_type . ' transaction payment';
            $details = 'Refunding '.  $orderItemDetails->itemable_type . ' transaction payment';
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
}
