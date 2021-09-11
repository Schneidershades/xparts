<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorQuoteController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/user/vendor-quote/{xpart_requests_id}",
    *      operationId="showQuotesUnderXpartRequest",
    *      tags={"User"},
    *      summary="showQuotesUnderXpartRequest",
    *      description="showQuotesUnderXpartRequest",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Xpart Request ID",
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
        return $this->showOne(auth()->user()->xpartRequests->where('id', $id)->first());
    }
}
