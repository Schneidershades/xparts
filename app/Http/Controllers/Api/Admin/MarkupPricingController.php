<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\MarkupPricing;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MarkupPricingCreateFormRequest;
use App\Http\Requests\Admin\MarkupPricingUpdateFormRequest;

class MarkupPricingController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/admin/markup-pricing",
    *      operationId="allMarkupPricing",
    *      tags={"Admin"},
    *      summary="Get all markup-pricing",
    *      description="Get all markup-pricing",
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
        $count = MarkupPricing::all()->count();
        if($count > 1){
            return $this->errorResponse('You cannot create any further. Kindly edit the one available', 409)
        }
        return $this->showAll(MarkupPricing::all());
    }

    /**
    * @OA\Post(
    *      path="/api/v1/admin/markup-pricing",
    *      operationId="postUser",
    *      tags={"Admin"},
    *      summary="Post markup-pricing",
    *      description="Post markup-pricing",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/MarkupPricingCreateFormRequest")
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
    public function store(MarkupPricingCreateFormRequest $request)
    {
        return $this->showOne(MarkupPricing::create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/markup-pricing/{id}",
    *      operationId="showMarkupPricing",
    *      tags={"Admin"},
    *      summary="Show markup-pricing",
    *      description="Show markup-pricing",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="markup-pricing ID",
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
        return $this->showOne(MarkupPricing::findOrFail($id));
    }

    /**
    * @OA\Put(
    *      path="/api/v1/admin/markup-pricing/{id}",
    *      operationId="UserMarkupPricing",
    *      tags={"Admin"},
    *      summary="Update markup-pricing",
    *      description="Update markup-pricing",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="markup-pricing ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/MarkupPricingUpdateFormRequest")
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
    
    public function update(MarkupPricingUpdateFormRequest $request, MarkupPricing $markupPricing)
    {
        ($markupPricing->update($request->validated()));
        return $this->showOne($markupPricing);
    }

     /**
    * @OA\Delete(
    *      path="/api/v1/admin/markup-pricing/{id}",
    *      operationId="deleteMarkupPricing",
    *      tags={"Admin"},
    *      summary="Delete markup-pricing",
    *      description="Delete markup-pricing",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="markup-pricing ID",
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
    public function destroy(MarkupPricing $markupPricing)
    {
        $markupPricing->delete();
        return $this->showMessage('deleted');
    }
}
