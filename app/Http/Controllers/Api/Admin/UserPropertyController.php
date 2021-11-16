<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\WalletTransaction;
use App\Models\XpartRequest;

class UserPropertyController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/user/{id}/orders",
    *      operationId="showUserOrder",
    *      tags={"Admin"},
    *      summary="showUserOrder",
    *      description="showUserOrder",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      
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
    public function orders($user_id)
    {
        return $this->showAll(Order::where('user_id', $user_id)->latest()->get());
    }

     /**
    * @OA\Get(
    *      path="/api/v1/admin/user/{id}/wallet-transactions",
    *      operationId="showUserWalletTransactions",
    *      tags={"Admin"},
    *      summary="showUserWalletTransactions",
    *      description="showUserWalletTransactions",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      
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
    public function walletTransactions($user_id)
    {
        return $this->showAll(WalletTransaction::where('user_id', $user_id)->latest()->get());
    }

     /**
    * @OA\Get(
    *      path="/api/v1/admin/user/{id}/quotes",
    *      operationId="showUserQuotes",
    *      tags={"Admin"},
    *      summary="showUserQuotes",
    *      description="showUserQuotes",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      
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
    public function quotes($user_id)
    {
        return $this->showAll(Quote::where('vendor_id', $user_id)->latest()->get());
    }

     /**
    * @OA\Get(
    *      path="/api/v1/admin/user/{id}/xparts-requests",
    *      operationId="showUserXpartRequests",
    *      tags={"Admin"},
    *      summary="showUserXpartRequests",
    *      description="showUserXpartRequests",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      
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
    public function xpartRequests($user_id)
    {
        return $this->showAll(XpartRequest::where('user_id', $user_id)->latest()->get());
    }
}
