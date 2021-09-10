<?php

namespace App\Http\Controllers\Api\Share;

use App\Models\Part;
use App\Models\CategoryOne;
use App\Http\Controllers\Controller;

class PartsController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/share/parts?title={search}",
    *      operationId="searchParts",
    *      tags={"Share"},
    *      summary="searchParts",
    *      description="searchParts",
    *      @OA\Parameter(
    *          name="search",
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
