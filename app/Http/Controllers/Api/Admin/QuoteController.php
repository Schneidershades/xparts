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
use App\Repositories\Models\WalletRepository;

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

        $order = Order::where('receipt_number',  $quote->receipt_number)->first();

        $quote->status = $request['status'];

        $quote->save();

        if($quote->status == "delivered"){
            $orderItem = $this->findOrderItemsForQuotesSelected($order, $quote);

            if(!$orderItem){
                return $this->errorResponse('Quote order item not found. Please contact support', 404);
            }

            if($orderItem->status == 'pending' || $orderItem->status == 'ordered'){
                $this->getWalletRepository()->creditVendors($order, $orderItem, $quote, 'successful', 'credit');
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

    protected function getWalletRepository(): WalletRepository
    {
        return new WalletRepository;
    }
}
