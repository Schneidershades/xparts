<?php

namespace App\Http\Controllers\Api\Test;

use App\Models\Vin;
use App\Models\Part;
use App\Models\User;
use App\Models\Order;
use App\Models\Quote;
use App\Jobs\SendEmail;
use App\Models\XpartRequest;
use App\Jobs\PushNotification;
use App\Events\VendorQuoteSent;
use App\Mail\User\XpartRequestMail;
use App\Http\Controllers\Controller;
use App\Models\XpartRequestVendorWatch;

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
                $x->address_id = $order->address_id;
                $x->save();
            }
        }
        
    }

    public function capitalizeAllPartsAndVins()
    {
        $vins =  Vin::all();

        foreach($vins as $vin){
            $vin->vin_number =  strtoupper($vin->vin_number);
            $vin->save(); 
        }

        $parts =  Part::all();

        foreach($parts as $part){
            $part->name =  strtoupper($part->name);
            $part->admin_attention = false;
            $part->save(); 
        }
    }

    public function giveVendorsBidRequest()
    {
        $xpartRequests = XpartRequest::where('status', 'active')
            ->whereDate('created_at', '<', now()->subDays(2)->setTime(0, 0, 0)->toDateTimeString())
            ->get();

        foreach($xpartRequests as $xpartRequest){
            $users = User::role('Vendor')->get(); 

            collect($users)->each(function ($user) use ($xpartRequest) {
                if($xpartRequest->status == 'active'){

                    $watch = XpartRequestVendorWatch::where('xpart_request_id', $xpartRequest->id)
                        ->where('vendor_id', $user['id'])->first();

                    if($watch == null){
                        XpartRequestVendorWatch::create([
                            'xpart_request_id' => $xpartRequest->id,
                            'vendor_id' => $user['id'],
                            'status' => 'active'
                        ]);

                        SendEmail::dispatch($user['email'], new XpartRequestMail($xpartRequest, $user))->onQueue('emails')->delay(5);

                        // if($user->has('fcmPushSubscriptions')){
                        //     PushNotification::dispatch(
                        //         $xpartRequest, 
                        //         $xpartRequest->id, 
                        //         $user, 
                        //         'New Xpart Request', 
                        //         'A new xpart request has been created'
                        //     )->delay(5);
                        // }
                    }                
                } 
            });
        }

        
    }
}
