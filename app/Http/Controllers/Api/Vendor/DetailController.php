<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Models\Address;
use App\Models\BankDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\DetailCreateFormRequest;

class DetailController extends Controller
{
    /**
    * @OA\Post(
    *      path="/api/v1/vendor/business-details",
    *      operationId="postVendorBusinessDetails",
    *      tags={"Vendor"},
    *      summary="postVendorBusinessDetails",
    *      description="postVendorBusinessDetails",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/DetailCreateFormRequest")
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
    
    public function store(DetailCreateFormRequest $request)
    {
        if(auth()->user()->addresses || auth()->user()->bankDetails ){
            return $this->errorResponse('details of the vendor has already been saved', 409);
        }
        
        $array = ['user_id' => auth()->user()->id];
        $address = new Address;
        $address = $this->requestAndDbIntersection($request, $address, [], $array);
        $address->save();

        $bankDetail = new BankDetail;
        $bankDetail = $this->requestAndDbIntersection($request, $bankDetail, [], $array);
        $bankDetail->save();

        return $this->showMessage('Details saved');
    }
}