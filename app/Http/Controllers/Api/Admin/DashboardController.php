<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Vin;
use App\Models\User;
use App\Models\Quote;
use App\Models\XpartRequest;
use App\Http\Controllers\Controller;
use App\Models\XpartRequestVendorWatch;

class DashboardController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/statistics",
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
        return $this->showContent([
            'userTypes' => [
                'customer' => [
                    'key' => 'customers',
                    'value' => User::where('role', 'user')->get()->count()
                ],

                'vendor' => [
                    'key' => 'vendors',
                    'value' => User::where('role', 'vendor')->get()->count()
                ],

                'admin' => [
                    'key' => 'admins',
                    'value' => User::where('role', 'admin')->get()->count()
                ],
            ],

            'xpartRequest' => [
                'all' =>[
                    'key' => 'all requests',
                    'value' => XpartRequest::all()->count()
                ],

                'active' =>[
                    'key' => 'active requests',
                    'value' => XpartRequest::where('status', 'active')->get()->count()
                ],

                'paid' =>[
                    'key' => 'paid requests',
                    'value' => XpartRequest::where('status', 'paid')->get()->count()
                ],

                'delivered2xparts' =>[
                    'key' => 'Vendor Delivery',
                    'value' => XpartRequest::where('status', 'vendor2xparts')->get()->count()
                ],

                'delivered2user' =>[
                    'key' => 'User Delivery',
                    'value' => XpartRequest::where('status', 'xparts2user')->get()->count()
                ],

                'expired' =>[
                    'key' => 'Expired Request',
                    'value' => XpartRequest::where('status', 'expired')->get()->count()
                ],
            ],

            'quotesNumbers' => [
                'all' =>[
                    'key' => 'all total sum',
                    'value' => Quote::all()->count()
                ],

                'active' =>[
                    'key' => 'active requests',
                    'value' => Quote::where('status', 'active')->get()->count()
                ],

                'paid' =>[
                    'key' => 'paid requests',
                    'value' => Quote::where('status', 'paid')->get()->count()
                ],

                'delivered2xparts' =>[
                    'key' => 'Vendor Delivery',
                    'value' => Quote::where('status', 'vendor2xparts')->get()->count()
                ],

                'delivered2user' =>[
                    'key' => 'User Delivery',
                    'value' => Quote::where('status', 'delivered')->get()->count()
                ],

                'expired' =>[
                    'key' => 'Expired Request',
                    'value' => Quote::where('status', 'expired')->get()->count()
                ],
            ],

            'salesTransaction' => [
                'all' =>[
                    'key' => 'all total sum',
                    'value' => Quote::all()->sum('price')
                ],

                'active' =>[
                    'key' => 'active requests',
                    'value' => Quote::where('status', 'active')->get()->sum('price')
                ],

                'paid' =>[
                    'key' => 'paid requests',
                    'value' => Quote::where('status', 'paid')->get()->sum('price')
                ],

                'delivered2xparts' =>[
                    'key' => 'Vendor Delivery',
                    'value' => Quote::where('status', 'vendor2xparts')->get()->sum('price')
                ],

                'delivered2user' =>[
                    'key' => 'User Delivery',
                    'value' => Quote::where('status', 'delivered')->get()->sum('price')
                ],

                'expired' =>[
                    'key' => 'Expired Request',
                    'value' => Quote::where('status', 'expired')->get()->sum('price')
                ],
            ],

            'vin' => [
                'all' =>[
                    'key' => 'all banks',
                    'value' => Vin::all()->count()
                ],
            ],

            'xpartRequestSentToVendors' => [
                'all' =>[
                    'key' => 'all requests',
                    'value' => XpartRequestVendorWatch::all()->count()
                ],

                'active' =>[
                    'key' => 'active requests',
                    'value' => XpartRequestVendorWatch::where('status', 'active')->get()->count()
                ],

                'paid' =>[
                    'key' => 'paid requests',
                    'value' => XpartRequestVendorWatch::where('status', 'paid')->get()->count()
                ],

                'delivered2xparts' =>[
                    'key' => 'Vendor Delivery',
                    'value' => XpartRequestVendorWatch::where('status', 'vendor2xparts')->get()->count()
                ],

                'delivered2user' =>[
                    'key' => 'User Delivery',
                    'value' => XpartRequestVendorWatch::where('status', 'xparts2user')->get()->count()
                ],

                'expired' =>[
                    'key' => 'Expired Request',
                    'value' => XpartRequestVendorWatch::where('status', 'expired')->get()->count()
                ],
            ],

            'quoteTransactions' => [
                'all' =>[
                    'key' => 'all total sum',
                    'value' => Quote::all()->sum('markup_price')
                ],

                'active' =>[
                    'key' => 'active requests',
                    'value' => Quote::where('status', 'active')->get()->sum('markup_price')
                ],

                'paid' =>[
                    'key' => 'paid requests',
                    'value' => Quote::where('status', 'paid')->get()->sum('markup_price')
                ],

                'delivered2xparts' =>[
                    'key' => 'Vendor Delivery',
                    'value' => Quote::where('status', 'delivered')->get()->sum('markup_price')
                ],

                'delivered2user' =>[
                    'key' => 'User Delivery',
                    'value' => Quote::where('status', 'delivered')->get()->sum('markup_price')
                ],

                'expired' =>[
                    'key' => 'Expired Request',
                    'value' => Quote::where('status', 'expired')->get()->sum('markup_price')
                ],
            ],

            'vin' => [
                'all' =>[
                    'key' => 'all banks',
                    'value' => Vin::all()->count()
                ],
            ],

            'banks' => [
                'all' =>[
                    'key' => 'all vin',
                    'value' => Vin::all()->count()
                ],
            ],
        ]);
    }
}
