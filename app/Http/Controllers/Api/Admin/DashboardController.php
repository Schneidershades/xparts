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
                    'value' => User::where('role', 'vendor')->get()->count()
                ],
            ],

            'xpartRequest' => [
                'all' =>[
                    'key' => 'all requests',
                    'value' => XpartRequest::all()->count()
                ],

                'active' =>[
                    'key' => 'active requests',
                    'value' => XpartRequest::where('role', 'active')->get()->count()
                ],

                'paid' =>[
                    'key' => 'paid requests',
                    'value' => XpartRequest::where('role', 'active')->get()->count()
                ],

                'delivered2xparts' =>[
                    'key' => 'Vendor Delivery',
                    'value' => XpartRequest::where('role', 'active')->get()->count()
                ],

                'delivered2user' =>[
                    'key' => 'User Delivery',
                    'value' => XpartRequest::where('role', 'active')->get()->count()
                ],

                'expired' =>[
                    'key' => 'Expired Request',
                    'value' => XpartRequest::where('role', 'expored')->get()->count()
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
