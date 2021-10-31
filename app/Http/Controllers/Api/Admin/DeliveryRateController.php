<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\DeliveryRate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryRateCreateFormRequest;
use App\Http\Requests\Admin\DeliveryRateUpdateFormRequest;

class DeliveryRateController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/admin/delivery-rates",
    *      operationId="allDeliveryRate",
    *      tags={"Admin"},
    *      summary="Get all delivery-rates",
    *      description="Get all delivery-rates",
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
        return $this->showAll(DeliveryRate::where('type', 'flat')->get());
    }

    /**
    * @OA\Post(
    *      path="/api/v1/admin/delivery-rates",
    *      operationId="postUser",
    *      tags={"Admin"},
    *      summary="Post delivery-rates",
    *      description="Post delivery-rates",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/DeliveryRateCreateFormRequest")
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
    public function store(DeliveryRateCreateFormRequest $request)
    {
        return $request->validated();
        return $this->showOne(DeliveryRate::create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/delivery-rates/{id}",
    *      operationId="showDeliveryRate",
    *      tags={"Admin"},
    *      summary="Show delivery-rates",
    *      description="Show delivery-rates",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="delivery-rates ID",
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
        return $this->showOne(DeliveryRate::findOrFail($id));
    }

    /**
    * @OA\Put(
    *      path="/api/v1/admin/delivery-rates/{id}",
    *      operationId="UserDeliveryRate",
    *      tags={"Admin"},
    *      summary="Update delivery-rates",
    *      description="Update delivery-rates",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="delivery-rates ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/DeliveryRateUpdateFormRequest")
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
    
    public function update(DeliveryRateUpdateFormRequest $request, DeliveryRate $deliveryRate)
    {
        ($deliveryRate->update($request->validated()));
        return $this->showOne($deliveryRate);
    }

     /**
    * @OA\Delete(
    *      path="/api/v1/admin/delivery-rates/{id}",
    *      operationId="deleteDeliveryRate",
    *      tags={"Admin"},
    *      summary="Delete delivery-rates",
    *      description="Delete delivery-rates",
    *      
    *      @OA\Parameter(
     *          name="id",
     *          description="delivery-rates ID",
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
    public function destroy(DeliveryRate $markupPricing)
    {
        $markupPricing->delete();
        return $this->showMessage('deleted');
    }
}
