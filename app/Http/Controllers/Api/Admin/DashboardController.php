<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\XpartRequest;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankDetail;
use App\Models\MarkupPricing;
use App\Models\Vin;
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
        // return $this->showContent([
        //     'vendors' => User::where('role', 'vendor')->get()->count(),
        //     'users' => User::where('role', 'user')->get()->count(),
        //     'xpartRequest' => XpartRequest::all()->count(),
        //     'transactions' => Order::where('status', 'fulfilled')->get()->count(),
        //     'total_sales' => Order::where('status', 'approved')->get()->sum('amount_paid'),
        // ]);


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

            'orderTransactions' => [
                'all' =>[
                    'key' => 'all total sum',
                    'value' => Order::all()->sum('amount_paid')
                ],

                'active' =>[
                    'key' => 'active requests',
                    'value' => Order::where('status', 'active')->get()->sum('amount_paid')
                ],

                'paid' =>[
                    'key' => 'paid requests',
                    'value' => Order::where('status', 'paid')->get()->sum('amount_paid')
                ],

                'delivered2xparts' =>[
                    'key' => 'Vendor Delivery',
                    'value' => Order::where('status', 'vendor2xparts')->get()->sum('amount_paid')
                ],

                'delivered2user' =>[
                    'key' => 'User Delivery',
                    'value' => Order::where('status', 'xparts2user')->get()->sum('amount_paid')
                ],

                'expired' =>[
                    'key' => 'Expired Request',
                    'value' => Order::where('status', 'expired')->get()->sum('amount_paid')
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

            // 'details' => [
            //     'vin' => Vin::all()->count(),
            //     'banks' => Bank::all()->count(),
            //     'bankDetails' => BankDetail::all()->count(),
            //     'markupPricings' => MarkupPricing::all()->count(),
            // ],

            // 'quotes' => [
            //     'xpartRequest' => XpartRequest::all()->count(),
            //     'customer' => User::where('role', 'vendor')->get()->count(),
            //     'users' => User::where('role', 'user')->get()->count(),
            //     'admin' => User::where('role', 'admin')->get()->count(),
            // ],

            // 'walletTransactions' => [
            //     'debits' => User::where('role', 'vendor')->get()->count(),
            //     'credits' => User::where('role', 'user')->get()->count(),
            // ],

            // 'categories' => [
            //     'parts' => User::where('role', 'vendor')->get()->count(),
            //     'vehicle_specializations' => User::where('role', 'user')->get()->count(),
            //     'parts_specializations' => User::where('role', 'user')->get()->count(),
            // ],

            // 'payment_methods' => [
            //     'parts' => User::where('role', 'vendor')->get()->count(),
            //     'vehicle_specializations' => User::where('role', 'user')->get()->count(),
            //     'parts_specializations' => User::where('role', 'user')->get()->count(),
            // ],
        ]);
    }
}
