<?php

namespace App\Http\Controllers\Api\Share;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\AddressCreateFormRequest;
use App\Http\Requests\Address\AddressUpdateFormRequest;

class AddressController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/share/addresses",
    *      operationId="allAddresses",
    *      tags={"Share"},
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
    *      path="/api/v1/user/addresses",
    *      operationId="postAddresses",
    *      tags={"User"},
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
        return $this->showMessage(auth()->user()->addresses->create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/user/addresses/{id}",
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
        return $this->showMessage(auth()->user()->addresses->where('id', $id)->first());
    }


    /**
    * @OA\Put(
    *      path="/api/v1/user/addresses/{id}",
    *      operationId="postAddresses",
    *      tags={"User"},
    *      summary="postAddresses",
    *      description="postAddresses",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/AddressUpdateFormRequest")
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
        return $this->showMessage(auth()->user()->addresses->update($request->validated()));
    }

    /**
    * @OA\Delete(
    *      path="/api/v1/user/addresses/{id}",
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
