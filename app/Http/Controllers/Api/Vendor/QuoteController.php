<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Vendor\QuoteCreateFormRequest;

class QuoteController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/vendor/quotes",
    *      operationId="allUsers",
    *      tags={"Vendor"},
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
        return $this->showAll(auth()->user()->quotes);
    }
    
    /**
    * @OA\Post(
    *      path="/api/v1/vendor/quotes",
    *      operationId="postQuotes",
    *      tags={"Vendor"},
    *      summary="postQuotes",
    *      description="postQuotes",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/QuoteCreateFormRequest")
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

    public function store(QuoteCreateFormRequest $request)
    {
        return $this->showOne(auth()->user()->quotes->create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/vendor/quotes/{id}",
    *      operationId="showQuotes",
    *      tags={"Admin"},
    *      summary="showQuotes",
    *      description="showQuotes",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Quote ID",
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
        return $this->showOne(auth()->user()->quotes->where('id', $id)->first());
    }

    /**
    * @OA\Delete(
    *      path="/api/v1/vendor/quotes/{id}",
    *      operationId="deleteQuotes",
    *      tags={"Vendor"},
    *      summary="deleteQuotes",
    *      description="deleteQuotes",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Quote ID",
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
    public function destroy(Request $request, $id)
    {
        auth()->user()->quotes->where('id', $id)->first()->delete();
        return $this->showMessage('Model deleted');
    }
}
