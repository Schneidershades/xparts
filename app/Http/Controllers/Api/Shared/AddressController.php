<?php

namespace App\Http\Controllers\Api\Shared;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\AddressCreateFormRequest;
use App\Http\Requests\Address\AddressUpdateFormRequest;

class AddressController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/shared/addresses",
    *      operationId="allAddresses",
    *      tags={"Shared"},
    *      summary="allAddresses",
    *      description="allAddresses",
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
        return $this->showAll(auth()->user()->addresses);
    }
    /**
    * @OA\Post(
    *      path="/api/v1/share/addresses",
    *      operationId="postAddresses",
    *      tags={"Share"},
    *      summary="postAddresses",
    *      description="postAddresses",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/AddressCreateFormRequest")
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
    public function store(AddressCreateFormRequest $request)
    {
        return $this->showOne(auth()->user()->addresses()->create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/share/addresses/{id}",
    *      operationId="showAddresses",
    *      tags={"Share"},
    *      summary="showAddresses",
    *      description="showAddresses",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Addresses ID",
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
        return $this->showOne(auth()->user()->addresses->where('id', $id)->first());
    }


    /**
    * @OA\Put(
    *      path="/api/v1/share/addresses/{id}",
    *      operationId="updateAddresses",
    *      tags={"Share"},
    *      summary="updateAddresses",
    *      description="updateAddresses",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/AddressUpdateFormRequest")
    *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Addresses ID",
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
    public function update(AddressUpdateFormRequest $request, $id)
    {
        auth()->user()->addresses->where('id', $id)->first()->update($request->validated());
        return $this->showOne(auth()->user()->addresses->where('id', $id)->first());
    }

    /**
    * @OA\Delete(
    *      path="/api/v1/share/addresses/{id}",
    *      operationId="deleteAddresses",
    *      tags={"Share"},
    *      summary="deleteAddresses",
    *      description="deleteAddresses",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Addresses ID",
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
        auth()->user()->addresses->where('id', $id)->first()->delete();
        return $this->showMessage('the address has been deleted');
    }
}
