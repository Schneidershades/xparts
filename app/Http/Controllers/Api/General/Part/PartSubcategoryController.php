<?php

namespace App\Http\Controllers\Api\General\Part;

use App\Models\PartSubcategory;
use App\Http\Controllers\Controller;

class PartSubcategoryController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/part-subcategories",
    *      operationId="allPartSubcategories",
    *      tags={"Share"},
    *      summary="allPartSubcategories",
    *      description="allPartSubcategories",
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
        return $this->showAll(PartSubcategory::all());
    }
}
