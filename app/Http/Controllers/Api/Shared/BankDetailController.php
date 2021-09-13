<?php

namespace App\Http\Controllers\Api\Shared;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\BankDetailCreateFormRequest;
use App\Http\Requests\Bank\BankDetailUpdateFormRequest;

class BankDetailController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/shared/bank-details",
    *      operationId="allBankDetails",
    *      tags={"Shared"},
    *      summary="allBankDetails",
    *      description="allBankDetails",
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
        return $this->showAll(auth()->user()->BankDetails);
    }
    /**
    * @OA\Post(
    *      path="/api/v1/shared/bank-details",
    *      operationId="postBankDetails",
    *      tags={"Shared"},
    *      summary="postBankDetails",
    *      description="postBankDetails",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/BankDetailCreateFormRequest")
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
    public function store(BankDetailCreateFormRequest $request)
    {
        return $this->showOne(auth()->user()->bankDetails()->create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/shared/bank-details/{id}",
    *      operationId="showBankDetails",
    *      tags={"Shared"},
    *      summary="showBankDetails",
    *      description="showBankDetails",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="BankDetails ID",
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
        return $this->showOne(auth()->user()->bankDetails->where('id', $id)->first());
    }


    /**
    * @OA\Put(
    *      path="/api/v1/shared/bank-details/{id}",
    *      operationId="updateBankDetails",
    *      tags={"Shared"},
    *      summary="updateBankDetails",
    *      description="updateBankDetails",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/AddressUpdateFormRequest")
    *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="BankDetails ID",
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
    public function update(BankDetailUpdateFormRequest $request, $id)
    {
        auth()->user()->bankDetails->where('id', $id)->first()->update($request->validated());
        return $this->showOne(auth()->user()->bankDetails->where('id', $id)->first());
    }

    /**
    * @OA\Delete(
    *      path="/api/v1/shared/bank-details/{id}",
    *      operationId="deleteBankDetails",
    *      tags={"Shared"},
    *      summary="deleteBankDetails",
    *      description="deleteBankDetails",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="BankDetails ID",
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
    public function destroy($id)
    {
        auth()->user()->bankDetails->where('id', $id)->first()->delete();
        return $this->showMessage('the address has been deleted');
    }
}
