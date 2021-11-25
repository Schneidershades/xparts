<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/admin/statuses",
    *      operationId="allStatuses",
    *      tags={"Admin"},
    *      summary="Get all status",
    *      description="Get all status",
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
        return [
            [
                'key' => 'active',
                'message' => 'Active',
                'type' => 'quotes',
            ],
            [
                'key' => 'expired',
                'message' => 'Expired',
                'type' => 'quotes',
            ],
            [
                'key' => 'delivered',
                'message' => 'Delivered',
                'type' => 'quotes',
            ],
            [
                'key' => 'ordered',
                'message' => 'Ordered',
                'type' => 'quotes',
            ],
            [
                'key' => 'vendor2xparts',
                'message' => 'Vendor2xparts',
                'type' => 'quotes',
            ],
            [
                'key' => 'paid',
                'message' => 'Paid',
                'type' => 'quotes',
            ],
            [
                'key' => 'refunded',
                'message' => 'Refunded',
                'type' => 'quotes',
            ],
            [
                'key' => 'pending',
                'message' => 'Pending',
                'type' => 'wallet_transactions',
            ],
            [
                'key' => 'approved',
                'message' => 'Approved',
                'type' => 'wallet_transactions',
            ],
            [
                'key' => 'declined',
                'message' => 'Declined',
                'type' => 'wallet_transactions',
            ],

            [
                'key' => 'pending',
                'message' => 'Pending',
                'type' => 'orders',
            ],
            [
                'key' => 'approved',
                'message' => 'Approved',
                'type' => 'orders',
            ],
            [
                'key' => 'declined',
                'message' => 'Declined',
                'type' => 'orders',
            ],
            [
                'key' => 'ordered',
                'message' => 'Ordered',
                'type' => 'orders',
            ],
            [
                'key' => 'paid',
                'message' => 'Paid',
                'type' => 'orders',
            ],
        ];
    }
}
