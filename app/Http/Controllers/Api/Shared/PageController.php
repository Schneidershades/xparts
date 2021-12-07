<?php

namespace App\Http\Controllers\Api\Shared;

use App\Models\Page;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/shared/pages/{slug}",
    *      operationId="showPublicPage",
    *      tags={"Shared"},
    *      summary="Show PublicPage",
    *      description="Show PublicPage",
     *      @OA\Parameter(
     *          name="id",
     *          description="showPublicPage Slug",
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
    public function __invoke($slug)
    {
        return $this->showOne(Page::where('slug', $slug)->first());
    }
}
