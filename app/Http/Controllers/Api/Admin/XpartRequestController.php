<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\XpartRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminXpartRequestUpdateFormRequest;

class XpartRequestController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/xpart-requests",
    *      operationId="allXpartRequest",
    *      tags={"Admin"},
    *      summary="allXpartRequest",
    *      description="allXpartRequest",
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
        return $this->showAll(XpartRequest::latest()->get());
    }


    /**
    * @OA\Post(
    *      path="/api/v1/admin/xpart-requests",
    *      operationId="postPart",
    *      tags={"Admin"},
    *      summary="postPart",
    *      description="postPart",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/XpartStoreFormRequest")
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
    public function store(XpartStoreFormRequest $request)
    {
        return $this->showOne(XpartRequest::create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/xpart-requests/{id}",
    *      operationId="showXpartRequest",
    *      tags={"Admin"},
    *      summary="Show XpartRequest",
    *      description="Show XpartRequest",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="XpartRequest ID",
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
    public function show($id)
    {
        return $this->showOne(XpartRequest::findOrFail($id));
    }

     /**
    * @OA\Put(
    *      path="/api/v1/admin/xpart-requests/{id}",
    *      operationId="updateXpartRequest",
    *      tags={"Admin"},
    *      summary="updateXpartRequest",
    *      description="updateXpartRequest",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="updateXpartRequest ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/AdminXpartRequestUpdateFormRequest")
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
    
    public function update(AdminXpartRequestUpdateFormRequest $request, $id)
    {
        $xpartRequest = XpartRequest::where('id', $id)->first();
        
        $xpartRequest->status = $request['admin_description'];

        $xpartRequest->save();
        
        return $this->showOne($xpartRequest);
    }

}
