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
    *      tags={"Vendor"},
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
        return $this->showContent([
            'quoteTransactions' => [

                'total_sales' =>[
                    'key' => 'Total ordered, delivered, paid',
                    'value' => Quote::where('vendor_id', auth()->user()->id)->where('status', 'delivered')->orWhere('status', 'paid')->get()->sum('price')
                ],

                'total_orders' =>[
                    'key' => 'active bids',
                    'value' => Quote::where('vendor_id', auth()->user()->id)->where('status', 'active')->get()->sum('price')
                ],

                'total_bids' =>[
                    'key' => 'bid quotes',
                    'value' => Quote::where('vendor_id', auth()->user()->id)->get()->count()
                ],
            ],
        ]);
    }
}
