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
                'key' => 'expired',
                'message' => 'Expired'
            ],
            [
                'key' => 'delivered',
                'message' => 'Delivered'
            ],
            [
                'key' => 'ordered',
                'message' => 'Ordered'
            ],
            [
                'key' => 'vendor2xparts',
                'message' => 'Vendor2xparts'
            ],
            [
                'key' => 'paid',
                'message' => 'Paid'
            ],
            [
                'key' => 'refunded',
                'message' => 'Refunded'
            ],
        ];
    }
}
