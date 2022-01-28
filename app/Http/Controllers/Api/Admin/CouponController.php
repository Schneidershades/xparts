<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminCouponFormRequest;
use App\Http\Requests\Admin\UpdateAdminCouponFormRequest;

class CouponController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/admin/coupons",
    *      operationId="allCoupons",
    *      tags={"Admin"},
    *      summary="Get all coupons",
    *      description="Get all coupons",
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
        return $this->showAll(Coupon::all());
    }

    /**
    * @OA\Post(
    *      path="/api/v1/admin/coupons",
    *      operationId="postCoupons",
    *      tags={"Admin"},
    *      summary="Post coupons",
    *      description="Post coupons",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/StoreAdminCouponFormRequest")
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
    public function store(StoreAdminCouponFormRequest $request)
    {
        return $this->showOne(Coupon::create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/coupons/{id}",
    *      operationId="showCoupons",
    *      tags={"Admin"},
    *      summary="Show coupons",
    *      description="Show coupons",
    *
     *      @OA\Parameter(
     *          name="id",
     *          description="coupons ID",
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
        return $this->showOne(Coupon::findOrFail($id));
    }

    /**
    * @OA\Put(
    *      path="/api/v1/admin/coupons/{id}",
    *      operationId="updateCoupons",
    *      tags={"Admin"},
    *      summary="Update coupons",
    *      description="Update coupons",
    *
     *      @OA\Parameter(
     *          name="id",
     *          description="coupons ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/UpdateAdminCouponFormRequest")
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

    public function update(UpdateAdminCouponFormRequest $request, Coupon $coupon)
    {
        ($coupon->update($request->validated()));
        return $this->showOne($coupon);
    }

     /**
    * @OA\Delete(
    *      path="/api/v1/admin/coupons/{id}",
    *      operationId="deleteCoupon",
    *      tags={"Admin"},
    *      summary="Delete coupons",
    *      description="Delete coupons",
    *
    *      @OA\Parameter(
     *          name="id",
     *          description="coupons ID",
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
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return $this->showMessage('deleted');
    }
}
