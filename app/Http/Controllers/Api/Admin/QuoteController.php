<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Quote;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminQuoteUpdateFormRequest;

class QuoteController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/quotes",
    *      operationId="allQuotes",
    *      tags={"Admin"},
    *      summary="allQuotes",
    *      description="allQuotes",
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
        return $this->showAll(Quote::latest()->get());
    }

     /**
    * @OA\Put(
    *      path="/api/v1/admin/quotes/{id}",
    *      operationId="updateQuotes",
    *      tags={"Admin"},
    *      summary="updateQuotes",
    *      description="updateQuotes",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="updateQuotes ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/AdminQuoteUpdateFormRequest")
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
    
    public function update(AdminQuoteUpdateFormRequest $request, $id)
    {
        $quote = Quote::where('id', $id)->first();
        
        $quote->status = $request->status;

        $quote->save();

        if($quote->status = "delivered"){
            
        }
        
        return $this->showOne($quote);
    }
}
