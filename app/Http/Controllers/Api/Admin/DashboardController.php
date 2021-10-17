<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\XpartRequest;
use App\Http\Controllers\Controller;

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
            'vendors' => User::where('role', 'vendor')->get()->count(),
            'users' => User::where('role', 'user')->get()->count(),
            'xpartRequest' => XpartRequest::all()->count(),
            'transactions' => Order::where('status', 'fulfilled')->get()->count(),
            'total_sales' => Order::where('status', 'approved')->get()->sum('amount_paid'),
        ]);
    }
}
