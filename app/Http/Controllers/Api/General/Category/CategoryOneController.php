<?php

namespace App\Http\Controllers\Api\General\Category;

use App\Http\Controllers\Controller;
use App\Models\CategoryOne;

class CategoryOneController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/category-one",
    *      operationId="allCategoryOne",
    *      tags={"Shared"},
    *      summary="allCategoryOne",
    *      description="allCategoryOne",
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
        return $this->showAll(CategoryOne::all());
    }
}
