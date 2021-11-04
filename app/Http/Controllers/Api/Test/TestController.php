<?php

namespace App\Http\Controllers\Api\Test;

use App\Models\User;
use App\Models\Order;
use App\Models\Quote;
use Illuminate\Support\Arr;
use App\Models\XpartRequest;
use App\Events\VendorQuoteSent;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function sendQuote()
    {
        $quotes = Quote::where('id', 1)->first();
        $user = User::where('id', 1)->first();
        $xpartRequest = XpartRequest::where('id', 1)->first();
        
        broadcast(new VendorQuoteSent($user, $xpartRequest, $quotes));

    }

    public function quoteProcessing()
    {
        $orders = Order::where('status', 'paid')->orWhere('status', 'ordered')->get();

        foreach($orders as $order){
            $itemables = $order->orderItems->pluck('itemable_id')->toArray();
            foreach($order->orderItems as $orderItem){
                $orderItem->receipt_number = $order->receipt_number;
                $orderItem->status = $order->status;
                $orderItem->save();
            }

            $items = Quote::whereIn('id', $itemables)->get();

            $xpartsIds = $items->pluck('xparts_request_id')->toArray();

            foreach($items as $item){
                $item->receipt_number = $order->receipt_number;
                $item->order_id = $order->id;
                $item->save();
            }

            $xpartRequest = XpartRequest::whereIn('id', $xpartsIds)->get();

            foreach($xpartRequest as $x){
                $x->receipt_number = $order->receipt_number;
                $x->order_id = $order->id;
                $x->save();
            }
        }
        
    }
}
