<?php

namespace App\Http\Controllers\Api\Shared;

use App\Models\Part;
use App\Http\Controllers\Controller;

class PartsController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/shared/parts?search={title}",
    *      operationId="searchParts",
    *      tags={"Shared"},
    *      summary="searchParts",
    *      description="searchParts",
    *      @OA\Parameter(
    *          name="title",
    *          description="Search Items",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="string"
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
    public function index()
    {
        if(!request('search') || strlen(request('search')) < 3){
            return $this->errorResponse('Cannot search less than 3 characters', 409);
        }
        return $this->showAll(Part::filter()->get());
    }
}