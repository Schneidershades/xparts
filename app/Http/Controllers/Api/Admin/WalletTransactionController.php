<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminWalletUpdateFormRequest;

class WalletTransactionController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/wallet-transactions",
    *      operationId="allWalletTransactions",
    *      tags={"Admin"},
    *      summary="allWalletTransactions",
    *      description="allWalletTransactions",
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
        return $this->showAll(WalletTransaction::latest()->get());
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/wallet-transactions/{id}",
    *      operationId="showWalletTransactions",
    *      tags={"Admin"},
    *      summary="showWalletTransactions",
    *      description="showWalletTransactions",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="WalletTransactions Receipt number",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
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

    public function show($id)
    {
        return $this->showOne(WalletTransaction::where('receipt_number', $id));
    }

     /**
    * @OA\Put(
    *      path="/api/v1/admin/wallet-transactions/{id}",
    *      operationId="updateWalletTransactions",
    *      tags={"Admin"},
    *      summary="updateWalletTransactions",
    *      description="updateWalletTransactions",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="updateVin ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/AdminWalletUpdateFormRequest")
    *      ),
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
    
    public function update(AdminWalletUpdateFormRequest $request, WalletTransaction $walletTransaction)
    {
        return $this->showOne(WalletTransaction::find($walletTransaction->id)->update($request->validated()));
    }
}
