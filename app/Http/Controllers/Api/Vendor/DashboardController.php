<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Models\Quote;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/vendor/statistics",
    *      operationId="statistics",
    *      tags={"Admin"},
    *      summary="statistics",
    *      description="statistics",
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
        // something like this, but we'll just have "Total sales", "Total Orders", "Total Bids"
        return $this->showContent([

            'quoteTransactions' => [
                
                'all' =>[
                    'key' => 'all total sum',
                    'value' => Quote::all()->count()
                ],

                'total' =>[
                    'key' => 'Total ordered, delivered, paid',
                    'value' => Quote::where('vendor_id', auth()->user()->id)->orWhere('status', 'ordered')->where('status', 'delivered')->orWhere('status', 'paid')->get()->sum('price')
                ],

                'active' =>[
                    'key' => 'active bids',
                    'value' => Quote::where('vendor_id', auth()->user()->id)->where('status', 'active')->get()->sum('price')
                ],

                'ordered' =>[
                    'key' => 'ordered bids',
                    'value' => Quote::where('vendor_id', auth()->user()->id)->where('status', 'ordered')->get()->sum('price')
                ],

                'delivered' =>[
                    'key' => 'Total ordered, delivered, paid',
                    'value' => Quote::where('status', 'delivered')->get()->sum('price')
                ],

                'paid' =>[
                    'key' => 'paid requests',
                    'value' => Quote::where('vendor_id', auth()->user()->id)->where('status', 'paid')->get()->sum('price')
                ],

                'delivered2xparts' =>[
                    'key' => 'Vendor Delivery',
                    'value' => Quote::where('vendor_id', auth()->user()->id)->where('status', 'vendor2xparts')->get()->sum('price')
                ],

                'expired' =>[
                    'key' => 'Expired Request',
                    'value' => Quote::where('vendor_id', auth()->user()->id)->where('status', 'expired')->get()->sum('price')
                ],
            ],

        ]);
    }
}
