<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Repositories\Models\CartRepository;
use App\Repositories\Models\CouponRepository;
use App\Repositories\Models\CouponTransactionRepository;
use App\Http\Requests\Coupon\StoreCouponApplyFormRequest;

class CouponController extends Controller
{
    public $cartRepository;
    public $couponRepository;
    public $couponTransactionRepository;

    public function __construct(
        CartRepository $cartRepository,
        CouponRepository $couponRepository,
        CouponTransactionRepository $couponTransactionRepository
    )
    {
        $this->cartRepository = $cartRepository;
        $this->couponRepository = $couponRepository;
        $this->couponTransactionRepository = $couponTransactionRepository;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/coupons",
     *      operationId="postCoupons",
     *      tags={"User"},
     *      summary="postCoupons",
     *      description="postCoupons",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreCouponApplyFormRequest")
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

    public function store(StoreCouponApplyFormRequest $request)
    {
        $coupon = $this->couponRepository->findCouponCode($request['code']);

        if($coupon == null){
    		return $this->errorResponse('coupon is not available', 400);
    	}

        if($coupon->no_of_users != null){
            if($coupon->no_of_users <= $coupon->couponTransactions->count()){
                return $this->errorResponse('number of users exceeded on this coupon', 400);
            }
        }


        $total = $this->cartRepository->totalCartMarkup(auth()->user()->cart);

        if($coupon->amount != null){
            $couponAmount = $coupon->amount;
        }

        if($coupon->percentage != null){
            $coupon = $coupon->percentage / 100;
            $couponAmount = $total * $coupon;
        }

        return $this->showMessage($couponAmount);

    }

    /**
     * @OA\Get(
     *      path="/api/v1/coupons/{id}",
     *      operationId="showCoupons",
     *      tags={"User"},
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
        return $this->showOne(Coupon::where('code',$id)->first());
    }
}
